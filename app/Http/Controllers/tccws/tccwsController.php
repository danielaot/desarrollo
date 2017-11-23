<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BESA\VInformacionEmpaqueFacturaDoctos as FactuClientes;
use App\Models\SCPRD\VInformacionEmpaqueFactura as InfoCargoFactura;
use App\Models\tccws\TDoctoDespachostcc as EstructuraDocto;
use Carbon\Carbon;
use App\Models\Genericas\Tercero;
use DB;
ini_set('max_execution_time', 300);

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
        $facturas = FactuClientes::select('fecha_remesa' ,
        'num_factura', 'tipo_docto', 'num_consecutivo',
        'nom_tercero', 'num_sucursal', 'desc_sucursal',
        'nit_tercero', 'date_creacion')
        ->whereNull('fecha_remesa')
        ->where('date_creacion', '>', '11-08-2017')
        ->distinct()->orderBy('num_factura')->get();

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

    }


    public function getPlano(Request $request){

      $data = $request->all();
      $data['unidades'] = [];
      $data['documentosReferencia'] = [];
      $data['estructura'] = EstructuraDocto::all();
      $data['fechadespacho'] = Carbon::today()->toDateString();
      $data['generarDocumentos'] = true;

      $facturasParaRemesas = [];

      $data['sucursales'] = collect($data['sucursales'])->filter(function($sucuMap){
        return $sucuMap['hasOneOrMoreSelected'] == true;
      })->values();

      foreach ($data['sucursales'] as $key => $sucursal) {
          foreach ($sucursal['facturasAEnviar'] as $key => $factura) {
            array_push($facturasParaRemesas, $factura);
          }
      }

      $IdsfacturasParaRemesas = collect($facturasParaRemesas)->pluck('num_factura')->all();
      $dataFacturas = InfoCargoFactura::select('tipo_empaque',
      'num_factura', DB::raw('SUM(num_empaque) as total_empaque'))
      ->whereIn('num_factura', $IdsfacturasParaRemesas)
      ->groupBy('num_factura', 'tipo_empaque')
      ->orderBy('num_factura','tipo_empaque')
      ->get();


      $arrayFactsGroup = collect($facturasParaRemesas)->map(function($factura) use($dataFacturas){
        $facturasFilter = collect($dataFacturas)->filter(function($fact) use($factura){
          return $fact['num_factura'] == $factura['num_factura'];
        })->values();
        $factura['unidadesEmpaque'] = $facturasFilter;
        return $factura;
      });

      $data['facturasSucursales'] = collect($arrayFactsGroup)->groupBy('num_sucursal');
      $sumaCajas = 0;$sumaPaletas = 0;$sumaLios = 0;$sumaPeso = 0;
      foreach ($data['sucursales'] as $key => $sucursal) {
        foreach ($data['facturasSucursales'][$sucursal['codigo']] as $key => $factura) {

          array_push($data['documentosReferencia'], array(
            'tipodocumento' => $factura['tipo_docto'],
            'numerodocumento' => $factura['num_consecutivo'],
            'fechadocumento' => Carbon::parse($factura['date_creacion'])->toDateString(),
          ));

          foreach ($factura['unidadesEmpaque'] as $key => $unidad) {
            if($unidad['tipo_empaque'] == 'CAJAS'){
              $sumaCajas += $unidad['total_empaque'];
            }elseif($unidad['tipo_empaque'] == 'PALETAS'){
              $sumaPaletas += $unidad['total_empaque'];
            }elseif($unidad['tipo_empaque'] == 'LIOS') {
              $sumaLios += $unidad['total_empaque'];
            }elseif($unidad['tipo_empaque'] == 'PESO'){
              $sumaPeso += $unidad['total_empaque'];
            }
          }
        }
      }

      array_push($data['unidades'],array("unidad" => "CAJAS", "cantidad" => $sumaCajas));
      array_push($data['unidades'],array("unidad" => "PALETAS", "cantidad" => $sumaPaletas));
      array_push($data['unidades'],array("unidad" => "LIOS", "cantidad" => $sumaLios));
      array_push($data['unidades'],array("unidad" => "PESO", "cantidad" => $sumaPeso));


      return response()->json($data);

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
