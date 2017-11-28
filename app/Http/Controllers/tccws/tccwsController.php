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
        $facturas = FactuClientes::select('fecha_remesa' , 'num_ciudad',
        'txt_direccion', 'txt_telefono', 'desc_ciudad', 'desc_departamento',
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
      $data['sucursalesFiltradas'] = $data['sucursalesFiltradas']->map(function($sucursal) use($data){

        $sumaCajas = 0;$sumaPaletas = 0;$sumaLios = 0;$sumaPeso = 0;
        $sucursal['documentosReferencia'] = [];
        $sucursal['unidades'] = [];
        $sucursal['direcciondestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['txt_direccion'];
        $sucursal['telefonodestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['txt_telefono'];
        $sucursal['ciudaddestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['desc_ciudad'];
        $sucursal['sededestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['desc_sucursal'];



        foreach ($data['facturasSucursales'][$sucursal['codigo']] as $key => $factura) {

            array_push($sucursal['documentosReferencia'], array(
              'tipodocumento' => trim($factura['tipo_docto']),
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
              }
            }

        }

        array_push($sucursal['unidades'],array(
          "tipounidad" => "CAJAS",
          "claseempaque" => '',
          "tipoempaque" => '',
          "dicecontener" => '',
          "cantidadunidades" => $sumaCajas,
          "kilosreales" => '',
          "largo" => '',
          "alto" => '',
          "ancho" => '',
          "pesovolumen" => '',
          "valormercancia" => '',
          "codigobarras" => '',
          "numerobolsa" => '',
          "referencias" => '',
          "unidadesinternas" => ''
        ));
        array_push($sucursal['unidades'],array(
          "tipounidad" => "PALETAS",
          "claseempaque" => '',
          "tipoempaque" => '',
          "dicecontener" => '',
          "cantidadunidades" => $sumaPaletas,
          "kilosreales" => '',
          "largo" => '',
          "alto" => '',
          "ancho" => '',
          "pesovolumen" => '',
          "valormercancia" => '',
          "codigobarras" => '',
          "numerobolsa" => '',
          "referencias" => '',
          "unidadesinternas" => ''
        ));
        array_push($sucursal['unidades'],array(
          "tipounidad" => "LIOS",
          "claseempaque" => '',
          "tipoempaque" => '',
          "dicecontener" => '',
          "cantidadunidades" => $sumaLios,
          "kilosreales" => '',
          "largo" => '',
          "alto" => '',
          "ancho" => '',
          "pesovolumen" => '',
          "valormercancia" => '',
          "codigobarras" => '',
          "numerobolsa" => '',
          "referencias" => '',
          "unidadesinternas" => ''
        ));
        return $sucursal;
      });

      return response()->json($data);

    }


    public function getPlano(Request $request){

      foreach ($request->sucursalesFiltradas as $key => $sucursal) {

        $sucursal['unidades'] = collect($sucursal['unidades'])->filter(function($unidad){
          return $unidad['cantidadunidades'] > 0;
        })->values();

        $data = [
          'clave' => 'BOGLINIO',
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
          'primerapellidoremitente'=> '',
          'segundoapellidoremitente'=> '',
          'razonsocialremitente'=> '',
          'naturalezaremitente' => '',
          'tipoidentificacionremitente' => '',
          'identificacionremitente' => '',
          'telefonoremitente' => '',
          'direccionremitente'=> '',
          'ciudadorigen' => '',
          'tipoidentificaciondestinatario' => '',
          'identificaciondestinatario' => $request->idTercero,
          'sededestinatario' => $sucursal['sededestinatario'],
          'primernombredestinatario' => '',
          'segundonombredestinatario' => '',
          'primerapellidodestinatario' => $request->apellido1Tercero,
          'segundoapellidodestinatario' => $request->apellido2Tercero,
          'razonsocialdestinatario' => $request->razonSocialTercero,
          'naturalezadestinatario' => '',
          'direcciondestinatario' => $sucursal['direcciondestinatario'],
          'telefonodestinatario' =>  $sucursal['telefonodestinatario'],
          'ciudaddestinatario' => $sucursal['ciudaddestinatario'],
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
          'sucursales' => $request->sucursalesFiltradas,
          'facturasSucursales' => [],
          'unidades' => $sucursal['unidades'],
          'documentosReferencia' => $sucursal['documentosReferencia'],
          'numeroReferenciaCliente' => '',
          'generarDocumentos' => true,
          'txt' => ''
        ];

        $data = $this->replaceData($data);
      }

      return response()->json($data);

    }

    public function replaceData($data){

      extract($data);

      $documento = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:cli="http://clientes.tcc.com.co/">'.chr(13) . chr(10);
      $documento .= ' <soap:Header/>'.chr(13) . chr(10);
      $documento .= '  <soap:Body>'.chr(13) . chr(10);
      $documento .= '   <cli:GrabarDespacho4>'.chr(13) . chr(10);
      $documento .= '     <cli:objDespacho>'.chr(13) . chr(10);

      $grupos = collect($estructura)->unique('ddt_grupo')->values();
      $grupos = collect($grupos)->pluck('ddt_grupo');

      foreach ($grupos as $key => $grupo) {
          $listado = collect($estructura)->where('ddt_grupo',$grupo)->sortBy('ddt_orden');
          $documento .= $this->replaceMvts($grupo,$listado,$data);
      }

      $documento .= '     </cli:objDespacho>'.chr(13) . chr(10);
      $documento .= '     <cli:remesa>0</cli:remesa>'.chr(13) . chr(10);
      $documento .= '     <cli:respuesta>0</cli:respuesta>'.chr(13) . chr(10);
      $documento .= '     <cli:mensaje>0</cli:mensaje>'.chr(13) . chr(10);
      $documento .= '   </cli:GrabarDespacho4>'.chr(13) . chr(10);
      $documento .= '  </soap:Body>'.chr(13) . chr(10);
      $documento .= '</soap:Envelope>';


      $data['txt'] = $documento;
      return $data;

    }


    public function replaceMvts($grupo,$listado,$data){

      extract($data);
      $documento = '';

      if($grupo == 'a'){

        foreach($listado as $seg){
            $segmento = $seg->ddt_segmento;
            $campo = $seg->ddt_campo;
            $metaEtiqueta = $seg->ddt_nombre;
            $lista = explode('&',$segmento);
            for($i = 0;$i<count($lista);$i++){
                if($campo != '' && $lista[$i] == 'var'){
                    $lista[$i] = $$campo;
                }elseif($campo === '' && $lista[$i] === 'var'){
                    $lista[$i] = $campo;
                }
            }
            $segmento = implode('',$lista);
            $documento .= '      <'.$metaEtiqueta.'>'.$segmento.'</'.$metaEtiqueta.'>'.chr(13) . chr(10);
          }
          return $documento;

      }elseif($grupo == 'b'){

        foreach ($unidades as $key => $unidad) {
          extract($unidad);
          $documento .= '      <unidad>'.chr(13) . chr(10);
          foreach($listado as $seg){
            $segmento = $seg->ddt_segmento;
            $campo = $seg->ddt_campo;
            $metaEtiqueta = $seg->ddt_nombre;
            $lista = explode('&',$segmento);
            for($i = 0;$i<count($lista);$i++){
              if($campo != '' && $lista[$i] == 'var'){
                $lista[$i] = $$campo;
              }elseif($campo === '' && $lista[$i] === 'var'){
                $lista[$i] = $campo;
              }
            }
            $segmento = implode('',$lista);
            $documento .= '       <'.$metaEtiqueta.'>'.$segmento.'</'.$metaEtiqueta.'>'.chr(13) . chr(10);
          }
          $documento .= '      </unidad>'.chr(13) . chr(10);
        }
        return $documento;

      }elseif($grupo == 'c'){

        foreach ($documentosReferencia as $key => $documentoRef) {
          extract($documentoRef);
          $documento .= '      <documentosReferencia>'.chr(13) . chr(10);
          foreach($listado as $seg){
            $segmento = $seg->ddt_segmento;
            $campo = $seg->ddt_campo;
            $metaEtiqueta = $seg->ddt_nombre;
            $lista = explode('&',$segmento);
            for($i = 0;$i<count($lista);$i++){
              if($campo != '' && $lista[$i] == 'var'){
                $lista[$i] = $$campo;
              }elseif($campo === '' && $lista[$i] === 'var'){
                $lista[$i] = $campo;
              }
            }
            $segmento = implode('',$lista);
            $documento .= '       <'.$metaEtiqueta.'>'.$segmento.'</'.$metaEtiqueta.'>'.chr(13) . chr(10);
          }
          $documento .= '      </documentosReferencia>'.chr(13) . chr(10);
        }
        return $documento;

      }
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
