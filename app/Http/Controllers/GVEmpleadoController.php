<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GVEPedido;
use App\Models\GVEPedidoDetalle;
use App\Models\GDirNacional;
use App\Models\GItem;
use App\Models\GBarra;

use PDF;
use DB;
use Validator;
use Redirect;

use Auth;

class GVEmpleadoController extends Controller
{
    public function indexfacturas()
    {
        $pedidos = GVEPedido::where('ped_estadopedido', 1)
                            ->get()
                            ->sortByDesc('ped_id');

        $directorio = GDirNacional::all();
        foreach ($directorio as $usuario) {
          $usuario->dir_txt_cedula = trim($usuario->dir_txt_cedula);
        }

        $directorio = $directorio->keyBy('dir_txt_cedula');

        foreach ($pedidos as $pedido) {
          $pedido->numfactura = str_pad($pedido->ped_id, 10, "0", STR_PAD_LEFT);
          if($directorio->has($pedido->ped_nitcliente))
            $pedido->nombrecliente = $directorio[$pedido->ped_nitcliente]['dir_txt_nombre'];
          if($directorio->has($pedido->ped_usuario))
            $pedido->nombrefacturador = $directorio[$pedido->ped_usuario]['dir_txt_nombre'];
        }

        $filtered = $pedidos->filter(function ($value, $key) {
            return $value['nombrecliente'] != '' && $value['nombrefacturador'] != '';
        });

        return view('layouts.generarventaempleado.reimprimirfactura', ['facturas' => $filtered]);
    }

    public function imprimir(Request $request)
    {
        $ped_id = $request->ped_id;
        $pedido = GVEPedido::where('ped_id',$ped_id)
                           ->with('pedidodetalle.item')
                           ->first();

        $directorio = GDirNacional::all();
        foreach ($directorio as $usuario) {
          $usuario->dir_txt_cedula = trim($usuario->dir_txt_cedula);
        }

        $directorio = $directorio->keyBy('dir_txt_cedula');

        $total_unidades = 0;
        $total_precio_unidades = 0;
        $total = 0;

        foreach ($pedido->pedidodetalle as $detalle) {
          $detalle->preciounidad = $detalle->det_valor/$detalle->det_cantida;
          $total_unidades += $detalle->det_cantida;
          $total_precio_unidades += $detalle->preciounidad;
          $total += $detalle->det_valor;
        }

        $pedido->numfactura = str_pad($pedido->ped_id, 10, "0", STR_PAD_LEFT);
        $pedido->nombrecliente = $directorio[$pedido['ped_nitcliente']]['dir_txt_nombre'];
        $pedido->fechaorden = date("Y-m-d", strtotime($pedido->ped_fechaorden));
        $pedido->total_unidades = $total_unidades;
        $pedido->total_precio_unidades = $total_precio_unidades;
        $pedido->total = $total;

        view()->share('pedido',$pedido);

        $pdf = PDF::loadView('layouts.generarventaempleado.facturapdf');
        return $pdf->stream('factura.pdf');
        //return view('layouts.facturapdf');
    }

    public function crear(Request $request)
    {
        return view('layouts.generarventaempleado.ventaempleado');
    }

    public function guardar(Request $request)
    {
        $rules = [
          'ped_usuario' => 'required',
          'ped_nitcliente' => 'required|exists:t_directorionacional,dir_txt_cedula',
          'det_referencia' => 'required|exists:barra,idBarra',
          'det_cantida' => 'required|numeric'
        ];

        $messages = [
          'ped_nitcliente.required' => 'La identificación del empleado(a) es obligatoria.',
          'ped_nitcliente.exists' => 'El empleado(a) ingresado no existe.',
          'det_referencia.required' => 'La referencia es obligatoria.',
          'det_referencia.exists' => 'La referencia ingresada no existe.',
          'det_cantida.required' => 'La cantidad es obligatoria.',
          'det_cantida.numeric' => 'La cantidad debe ser nnumérica.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
          $messages = $validator->messages();

          return Redirect::to('generarventa')
                         ->withInput()
                         ->withErrors($validator);
        }

        $inputs = $request->all();
        $referencia = $request->det_referencia;
        $cantidad = $request->det_cantida;
        $usuario = $request->ped_usuario;
        $cliente = $request->ped_nitcliente;

        $item = GItem::whereHas('barra', function($q) use($referencia){
                              $q->where('idBarra', $referencia);
                           })
                     ->first();

        $itemInfo = DB::connection('besa')
                     ->table('000_LP-004')
                     //->select('precio')
                     ->where(['lp' =>'LFI', 'referencia' => $item->referenciaItem])
                     ->get()
                     ->sortByDesc('fecha_activacion')
                     ->first();

        $precio = $itemInfo->precio;

        if($request->ped_id == ''){
          $pedido = GVEPedido::where(['ped_nitcliente' => $cliente, 'ped_estadopedido' => '0'])
                             ->first();

          if(!$pedido){
            $pedido = new GVEPedido;
            $pedido->ped_nitcliente = $cliente;
            $pedido->ped_fechaorden = date('Y-m-d H:i:s');
            $pedido->ped_usuario = $usuario;
            $pedido->ped_estadopedido = 0;
            $pedido->save();
          }

          $inputs['ped_id'] = $pedido->ped_id;
        }

        $pedidodetalles = GVEPedidoDetalle::where(['det_idpedido' => $inputs['ped_id'], 'det_referencia' => $item->referenciaItem])
                                          ->first();

        if(count($pedidodetalles) > 0){
          $det_cantida = $cantidad+$pedidodetalles->det_cantida;
          $det_valor = ($cantidad*$precio)+$pedidodetalles->det_valor;

          GVEPedidoDetalle::where(['det_idpedido' => $inputs['ped_id'], 'det_referencia' => $item->referenciaItem])
                          ->update(['det_cantida' => $det_cantida, 'det_valor' => $det_valor, 'det_usuariomov' => $usuario]);
        }
        else{
          $pedidodetalle = new GVEPedidoDetalle;
          $pedidodetalle->det_idpedido = $inputs['ped_id'];
          $pedidodetalle->det_referencia = $item->referenciaItem;
          $pedidodetalle->det_cantida = $cantidad;
          $pedidodetalle->det_valor = $cantidad*$precio;
          $pedidodetalle->det_usuariomov = $usuario;
          $pedidodetalle->save();
        }

        /*$pedido = GVEPedido::with('pedidodetalle.item')
                           ->where('ped_id', $inputs['ped_id'])
                           ->get()
                           ->first();*/

        $pedido = GVEmpleadoController::pedidodetalle($inputs['ped_id']);

        return view('layouts.generarventaempleado.ventaempleado', ['pedido' => $pedido, 'inputs' => $inputs]);
        //return response()->json($infopedido);
    }

    public function finalizar(Request $request)
    {
        GVEPedido::where('ped_id', $request->ped_id)
                 ->update(['ped_estadopedido' => '1']);

        $inputs = ['ped_id' => '',
                  'ped_usuario' => '',
                  'ped_nitcliente' => '',
                  'det_referencia' => '',
                  'det_cantida' => '1',
                  'fincompra' => 1];

        return view('layouts.generarventaempleado.ventaempleado', ['pedido' => [], 'inputs' => $inputs]);
    }

    public function eliminar(Request $request)
    {
        GVEPedidoDetalle::where(['det_idpedido' => $request->ped_id, 'det_referencia' => $request->ref_id])
                        ->delete();

        $pedido = GVEmpleadoController::pedidodetalle($request->ped_id);

        $inputs = ['ped_id' => $pedido->ped_id,
                   'ped_usuario' => $pedido->ped_usuario,
                   'ped_nitcliente' => $pedido->ped_nitcliente,
                   'det_referencia' => '',
                   'det_cantida' => '1'];

        return view('layouts.generarventaempleado.ventaempleado', ['pedido' => $pedido, 'inputs' => $inputs]);
    }

    public function pedidodetalle($id)
    {
        $pedido = GVEPedido::with('pedidodetalle.item')
                           ->where('ped_id', $id)
                           ->first();

        $total_unidades = 0;
        $total = 0;

        foreach ($pedido->pedidodetalle as $detalle) {
          $total_unidades += $detalle->det_cantida;
          $total += $detalle->det_valor;
        }

        $pedido->total_unidades = $total_unidades;
        $pedido->total = $total;

        return $pedido;
    }


    public function example()
    {
      return 'Mostrar';
    }
}
/*
// show datatables page
public function reimprimirfactura(){
  return view('layouts.reimprimirfactura');
}

// show all posts data
public function facturasdata(){
  $pedidos = GVEPedido::where('ped_estadopedido', 1)
                      ->get();

  $directorio = GDirNacional::all()->keyBy('dir_txt_cedula');

  foreach ($pedidos as $pedido) {
    if($directorio->has($pedido->ped_nitcliente))
      $pedido->nombrecliente = $directorio[$pedido->ped_nitcliente]['dir_txt_nombre'];
    if($directorio->has($pedido->ped_usuario))
      $pedido->nombrefacturador = $directorio[$pedido->ped_usuario]['dir_txt_nombre'];
  }

  $filtered = $pedidos->filter(function ($value, $key) {
      return $value['nombrecliente'] != '' && $value['nombrefacturador'] != '';
  });
  return Datatables::of($filtered)->make(true);
}

*/
