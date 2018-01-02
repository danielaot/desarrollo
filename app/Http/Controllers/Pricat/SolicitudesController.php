<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Auth;

use App\Models\Genericas\Item as ItemERP;
use App\Models\Genericas\Barra as Ean;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TCliente as Cliente;
use App\Models\Pricat\TSolPricat as SolPricat;
use App\Models\Pricat\TSolPricatDetalle as SolPricatDetalle;
use App\Models\BESA\AppwebListaPrecio as ListaPrecio;


use DB;
ini_set('memory_limit', '-1');

class SolicitudesController extends Controller
{
    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Pricat // Mis Solicitudes';
        $titulo = 'Mis Solicitudes';

        $solicitudes = SolPricat::with('clientes.terceros')
                                ->get();

        $response = compact('ruta', 'titulo', 'solicitudes');

        return view('layouts.pricat.solicitud.indexSolicitudes', $response);
    }

    public function getInfo()
    {
        $solicitudes = SolPricat::with('detalles.items.detalles')
                                ->where('sop_kam', Auth::user()->idTerceroUsuario)
                                ->get();

        $response = compact('solicitudes');

        return response()->json($response);
    }

    public function create()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Pricat // Crear Solicitud';
        $titulo = 'Crear Solicitud';

        $response = compact('ruta', 'titulo');

        return view('layouts.pricat.solicitud.createSolicitud', $response);
    }

    public function getCreateInfo()
    {
        $cliente = Cliente::where(['cli_kam' => Auth::user()->idTerceroUsuario, 'cli_nit' => '900626402'])
                          ->get()->count();

        if($cliente > 0){
          $itemslogyca = Item::with('detalles')
                             ->whereHas('proyectos', function($q){
                                            $q->where('proy_estado', 'Terminado');
                                      })
                             ->get();
        }
        else{
          $itemslogyca = Item::with('detalles')
                             ->whereHas('proyectos', function($q){
                                            $q->where('proy_estado', 'Terminado');
                                      })
                             ->where('ite_est_logyca','<>','No Capturado')
                             ->get();
        }

        $itemserp = ItemERP::all();

        $response = compact('itemserp', 'itemslogyca');

        return response()->json($response);
    }

    public function precioBruto(Request $request)
    {
      $cliente = Cliente::where(['cli_kam' => Auth::user()->idTerceroUsuario])
                        ->get();

      if ($request->ite_referencia != null) {
          $lp = $cliente[0]['cli_listaprecio'];
          $referencia = $request->ite_referencia;

          $precio = DB::connection('besa')
                      ->select("SELECT TOP 1 *
                                FROM [BESA].[dbo].[000_LP-004]
                                WHERE  lp = '$lp' and referencia = '$referencia'
                                ORDER BY fecha_activacion DESC");

      }elseif ($request->ite_referencia == null) {
              $lp = $cliente[0]['cli_listaprecio'];
              $referencia = $request->referenciaItem;

              $precio = DB::connection('besa')
              ->select("SELECT TOP 1 *
                FROM [BESA].[dbo].[000_LP-004]
                WHERE  lp = '$lp' and referencia = '$referencia'
                ORDER BY fecha_activacion DESC");
        }
      return ($precio);
    }

    public function referencia(Request $request)
    {
      $referencias = $request->all();
      $refTodas = [];
      $refTodasCompleto = [];

      foreach ($referencias as $key => $value) {
        $ref = $value['referencia'];
        $ean13 = $value['ean13'];
        array_push($refTodas, $ref);
        array_push($refTodasCompleto, $value);
      }

        $referenciaerp = ItemERP::whereIn('referenciaItem', $refTodas)->get();

        $cliente = Cliente::where(['cli_kam' => Auth::user()->idTerceroUsuario])
                          ->get();
        if ($ean13 == null) {
          $lp = $cliente[0]['cli_listaprecio'];

          $referencia = implode($refTodas , "','");

          $precio = DB::connection('besa')
          ->select("SELECT  *
            FROM [BESA].[dbo].[000_LP-004]
            WHERE  lp = '$lp' and referencia IN ('$referencia')
            ORDER BY fecha_activacion DESC");

            $datos = collect($refTodasCompleto)->map(function($ref) use($precio){

              $infoRefe = collect($precio)->filter(function($pre) use($ref){
                return trim($pre->referencia) == trim($ref['referencia']);
              })->filter()->values();

              $ref['informacionPrecio'] = $infoRefe[0];
              return $ref;
            });
        }elseif ($ean13 !== null) {

          $items = [];

          foreach ($referenciaerp as $key => $value) {
            $idItem = $value['idItem'];
            array_push($items, $idItem);
          }
          $ean = Ean::with('item')->whereIn('idItemBarra', $items)->get();

          foreach ($ean as $key => $value) {
            if ($ean13 == $value['idBarra']) {
              return ("EXTISO");
            }elseif ($ean13 != $value['idBarra']) {
              return ("ERROR EN LOS EAN 13");
            }

          }
        //  return ($ean);

          $items = Item::whereIn('ite_referencia', $refTodas)->get();
        }

      $response = compact('datos');

      return response()->json($response);

    }

    public function store(Request $request)
    {
        $validationRules = [
          'tnovedad' => 'required',
          'referencias' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $cliente = Cliente::where(['cli_kam' => Auth::user()->idTerceroUsuario])
                          ->get()->first();

        $solicitud = new SolPricat;
        $solicitud->sop_cliente = $cliente->id;
        $solicitud->sop_kam = $cliente->cli_kam;
        $solicitud->sop_tnovedad = $request->tnovedad;
        $solicitud->sop_fecha_inicio = Carbon::createFromFormat('D M d Y', $request->inicio)->toDateString();
        $solicitud->sop_fecha_fin = Carbon::createFromFormat('D M d Y', $request->fin)->toDateString();
        $solicitud->save();

        if ($request->tmodifica != 'suspension' ) {
          foreach ($request->referencias as $referencia){
            $detalle = new SolPricatDetalle;
            $detalle->spd_sol = $solicitud->id;
            $detalle->spd_referencia = $referencia['referencia'];
            $detalle->spd_preciobruto = $referencia['prebru'];
            $detalle->spd_preciosugerido = $referencia['presug'];
            $detalle->save();
          }
        }elseif ($request->tmodifica == 'suspension') {
          foreach ($request->referencias as $referencia){
            $detalle = new SolPricatDetalle;
            $detalle->spd_sol = $solicitud->id;
            $detalle->spd_referencia = $referencia['referencia'];
            $detalle->spd_preciobruto = $referencia['prebru'];
            $detalle->spd_preciosugerido = 0;
            $detalle->save();
          }
        }

        $url = url('pricat/solicitud');
        return response($url, 200);
    }
}
