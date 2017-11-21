<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BESA\VInformacionEmpaqueFacturaDoctos as FactuClientes;
use App\Models\SCPRD\VInformacionEmpaqueFactura as InfoCargoFactura;
use Carbon\Carbon;
use App\Models\Genericas\Tercero;

class tccwsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "SGA // AGRUPAR REMESA";
        $titulo = "Agrupar remesa";
        $response = compact('ruta', 'titulo');
        return view('layouts.tccws.pedidosAgruparIndex', $response);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agrupaPedidosGetInfo()
    {
        $facturas = FactuClientes::select('fecha_remesa' ,'num_factura', 'tipo_docto', 'num_consecutivo', 'nom_tercero', 'num_sucursal', 'desc_sucursal', 'nit_tercero')->whereNull('fecha_remesa')->where('date_creacion', '>', '11-08-2017')->orderBy('num_factura')->get();
        $agrupoCliente = $facturas->groupBy('nit_tercero');
        $soloCliente = $agrupoCliente->keys()->all();
        $terceros = Tercero::whereIn('idTercero', $soloCliente)->get();

        $sucursales = [];
        foreach ($agrupoCliente as $key => $value) {
            $agrupoSucursal = collect($value)->groupBy('num_sucursal');
            foreach ($agrupoSucursal as $key => $value) {
                $sucu['codigo'] = $key;
                $sucu['nombre'] = $value[0]['desc_sucursal'];
                $sucu['nit_tercero'] = $value[0]['nit_tercero'];
                array_push($sucursales, $sucu);

            }
        }

        $response = compact('agrupoCliente', 'terceros', 'soloCliente', 'sucursales');
        return response()->json($response);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      $facturasParaRemesas = [];
      foreach ($data['sucursales'] as $key => $sucursal) {
        if($sucursal['hasOneOrMoreSelected'] == true){
          foreach ($sucursal['facturasAEnviar'] as $key => $factura) {
            array_push($facturasParaRemesas, $factura['num_factura']);
          }
        }
      }

      $dataFacturas = InfoCargoFactura::whereIn('num_factura', $facturasParaRemesas)->get();

      return response()->json($dataFacturas);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
