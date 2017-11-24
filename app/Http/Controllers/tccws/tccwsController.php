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
        ->whereNotIn('tipo_docto', ['F30', 'F28', 'F31', 'F48'])
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

    public function getUnidadesLogisticas(Request $request){

      $data = $request->all();
      $facturasParaRemesas = [];
      $data['documentosReferencia'] = [];
      $data['unidades'] = [];
      $data['sucursalesFiltradas'] = [];
      $sucursales = collect($data['sucursales']);

      $data['sucursalesFiltradas'] = $sucursales->filter(function($sucuMap){
        return $sucuMap['hasOneOrMoreSelected'] == true;
      })->values();

      foreach ($data['sucursalesFiltradas'] as $key => $sucursal) {
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
      foreach ($data['sucursalesFiltradas'] as $key => $sucursal) {
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


    public function getPlano(Request $request){


      $data = [
        'clave' => '',
        'codigolote' => '',
        'fechahoralote' => '',
        'numeroremesa' => '',
        'numeroDepacho' => '',
        'unidadnegocio' => '',
        'fechadespacho' => Carbon::today()->toDateString(),
        'cuentaremitente' => '',
        'sederemitente' => '',
        'primernombreremitente' => '',
        'segundonombreremitente' => '',
        'primerapellidoremitente'=> $request->apellido1Tercero,
        'segundoapellidoremitente'=> $request->apellido2Tercero,
        'razonsocialremitente'=> $request->razonSocialTercero,
        'naturalezaremitente' => '',
        'tipoidentificacionremitente' => '',
        'identificacionremitente' => $request->idTercero,
        'telefonoremitente' => '',
        'direccionremitente'=> '',
        'ciudadorigen' => '',
        'tipoidentificaciondestinatario' => '',
        'identificaciondestinatario' => '',
        'sededestinatario' => '',
        'primernombredestinatario' => '',
        'segundonombredestinatario' => '',
        'primerapellidodestinatario' => '',
        'segundoapellidodestinatario' => '',
        'razonsocialdestinatario' => '',
        'naturalezadestinatario' => '',
        'direcciondestinatario' => '',
        'telefonodestinatario' => '',
        'ciudaddestinatario' => '',
        'barriodestinatario' => '',
        'totalpeso' => '',
        'totalpesovolumen' => '',
        'formapago' => '',
        'observaciones' => '',
        'llevabodega' => '',
        'recogebodega' => '',
        'centrocostos' => '',
        'totalvalorproducto' => '',
        'estructura' => EstructuraDocto::all(),
        'sucursales' => $request->sucursales,
        'facturasSucursales' => [],
        'unidades' => [],
        'documentosReferencia' => [],
        'numeroReferenciaCliente' => '',
        'generarDocumentos' => true,
        'txt' => ''
      ];

      //$data = $this->replaceData($data);

      return response()->json($data);

    }

    public function replaceData($data){

      $documento = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:cli="http://clientes.tcc.com.co/">'.chr(13) . chr(10);
      $documento .= ' <soap:Header/>'.chr(13) . chr(10);
      $documento .= '  <soap:Body>'.chr(13) . chr(10);
      $documento .= '   <cli:GrabarDespacho4>'.chr(13) . chr(10);
      $documento .= '     <cli:objDespacho>'.chr(13) . chr(10);

      $grupos = collect($data['estructura'])->unique('ddt_grupo')->values();
      $grupos = collect($grupos)->pluck('ddt_grupo');

      foreach ($grupos as $key => $grupo) {

          $listado = collect($data['estructura'])->where('ddt_grupo',$grupo)->sortBy('ddt_orden');
          foreach($listado as $seg){
              $segmento = $seg->dpe_segmento;
              $campo = $seg->dpe_campo;
              $lista = explode('&',$segmento);
              for($i = 0;$i<count($lista);$i++){
                  if($campo != '' && $lista[$i] == 'var'){
                      $lista[$i] = $$campo;
                  }elseif($campo === '' && $lista[$i] === 'var'){
                      $lista[$i] = $campo;
                  }
              }
              $segmento = implode('',$lista);
          }

          if($grupo == 'b'){


          }

      }

      foreach ($listadoObjetoDespacho as $key => $campo) {
        $documento .= '      <'.$campo['ddt_nombre'].'>'.'</'.$campo['ddt_nombre'].'>'.chr(13) . chr(10);
      }

      $data['txt'] = $documento;
      return $data;

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
