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
use nusoap_client;
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

      //Se filtran las sucursales por las que tiene una o mas facturas seleccionadas
      $data['sucursalesFiltradas'] = $sucursales->filter(function($sucuMap){
        return $sucuMap['hasOneOrMoreSelected'] == true;
      })->values();
      //Por cada sucursal con referencias seleccionadas se hace un recorrido de sus facturas para adjuntarlas todas en un unico array
      foreach ($data['sucursalesFiltradas'] as $key => $sucursal) {
          foreach ($sucursal['facturasAEnviar'] as $key => $factura) {
            array_push($facturasParaRemesas, $factura);
          }
      }
      //Del array de todas las facturas solo tomamos los id´s para posterior realizar un whereIn en la vista
      $IdsfacturasParaRemesas = collect($facturasParaRemesas)->pluck('num_factura')->all();
      //Se realiza la consulta a la vista con los codigos de las facturas
      $dataFacturas = InfoCargoFactura::select('tipo_empaque',
      'num_factura', DB::raw('SUM(num_empaque) as total_empaque'))
      ->whereIn('num_factura', $IdsfacturasParaRemesas)
      ->groupBy('num_factura', 'tipo_empaque')
      ->orderBy('num_factura','tipo_empaque')
      ->get();

      //Se hace un map para todas las facturas para asi agregarle a cada una su información de unidades logisticas
      $arrayFactsGroup = collect($facturasParaRemesas)->map(function($factura) use($dataFacturas){
        //Se obtiene la informacion logistica de cada factura haciendo un filter a la informacion obtenida de la vista
        $facturasFilter = collect($dataFacturas)->filter(function($fact) use($factura){
          return $fact['num_factura'] == $factura['num_factura'];
        })->values();
        //Se asigna la informacion logistica para la factura que esta en el momento iterando
        $factura['unidadesEmpaque'] = $facturasFilter;
        //retorno la factura con la nueva informacion
        return $factura;
      });

      //Agrupo todas las facturas por sucursal
      $data['facturasSucursales'] = collect($arrayFactsGroup)->groupBy('num_sucursal');
      //De todas las sucursales con facturas pendientes se hace un recorrido por cada una para realizar una serie de operaciones
      $data['sucursalesFiltradas'] = $data['sucursalesFiltradas']->map(function($sucursal) use($data){

        $sumaCajas = 0;$sumaPaletas = 0;$sumaLios = 0;$sumaPeso = 0;
        $sucursal['documentosReferencia'] = [];
        $sucursal['unidades'] = [];
        //Se obtiene la informacion de la sucursal desde las facturas agrupadas por sucursal
        $sucursal['direcciondestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['txt_direccion'];
        $sucursal['telefonodestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['txt_telefono'];
        $sucursal['ciudaddestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['desc_ciudad'];
        $sucursal['sededestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['desc_sucursal'];


        //Se hace un recorrido por cada factura de una sucursal
        foreach ($data['facturasSucursales'][$sucursal['codigo']] as $key => $factura) {
          //Guardamos los documentos de referencia que iran en el plano que se envia a tcc
            array_push($sucursal['documentosReferencia'], array(
              'tipodocumento' => trim($factura['tipo_docto']),
              'numerodocumento' => $factura['num_consecutivo'],
              'fechadocumento' => Carbon::parse($factura['date_creacion'])->toDateString(),
            ));
            //Se hace una totalizacion general de las unidades logisticas del pedido
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
        //Se anexa a un arreglo de sucursal las unidades logisticas totalizadas
        array_push($sucursal['unidades'],array(
          "tipounidad" => "TIPO_UND_PAQ",
          "claseempaque" => 'CLEM_CAJA',
          "tipoempaque" => '',
          "dicecontener" => '',
          "cantidadunidades" => $sumaCajas,
          "kilosreales" => '',
          "largo" => 0,
          "alto" => 0,
          "ancho" => 0,
          "pesovolumen" => 0,
          "valormercancia" => 30000,
          "codigobarras" => '',
          "numerobolsa" => '',
          "referencias" => '',
          "unidadesinternas" => ''
        ));
        array_push($sucursal['unidades'],array(
          "tipounidad" => "TIPO_UND_PAQ",
          "claseempaque" => 'CLEM_PALET',
          "tipoempaque" => '',
          "dicecontener" => '',
          "cantidadunidades" => $sumaPaletas,
          "kilosreales" => '',
          "largo" => 0,
          "alto" => 0,
          "ancho" => 0,
          "pesovolumen" => 0,
          "valormercancia" => 30000,
          "codigobarras" => '',
          "numerobolsa" => '',
          "referencias" => '',
          "unidadesinternas" => ''
        ));
        array_push($sucursal['unidades'],array(
          "tipounidad" => "TIPO_UND_PAQ",
          "claseempaque" => 'CLEM_LIO',
          "tipoempaque" => '',
          "dicecontener" => '',
          "cantidadunidades" => $sumaLios,
          "kilosreales" => '',
          "largo" => 0,
          "alto" => 0,
          "ancho" => 0,
          "pesovolumen" => 0,
          "valormercancia" => 30000,
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

      $message = '';
      //Se organiza el plano por cada sucursal
      foreach ($request->sucursalesFiltradas as $key => $sucursal) {
        //Se obtienen solo las unidades logisticas las cuales su cantidad en unidades es mayor a '0'
        $sucursal['unidades'] = collect($sucursal['unidades'])->filter(function($unidad){
          return $unidad['cantidadunidades'] > 0;
        })->values();

        $data = [
          'clave' => 'calbelleza',
          'codigolote' => '',
          'fechahoralote' => '',
          'numeroremesa' => '',
          'numeroDepacho' => '',
          'unidadnegocio' => '1',
          'fechadespacho' => Carbon::today()->toDateString(),
          'cuentaremitente' => '1125800',
          'sederemitente' => '',
          'primernombreremitente' => 'EJEMPLO BELLEZA EXPRESS',
          'segundonombreremitente' => '',
          'primerapellidoremitente'=> '',
          'segundoapellidoremitente'=> '',
          'razonsocialremitente'=> 'EJEMPLO BELLEZA EXPRESS',
          'naturalezaremitente' => 'J',
          'tipoidentificacionremitente' => 'NIT',
          'identificacionremitente' => '800118334',
          'telefonoremitente' => '5552255',
          'direccionremitente'=> 'Calle 36 No 134 - 201 Km 6 Via Cali Jamundi',
          'ciudadorigen' => '11001000',
          'tipoidentificaciondestinatario' => '',
          'identificaciondestinatario' => $request->idTercero,
          'sededestinatario' => '',
          'primernombredestinatario' => '',
          'segundonombredestinatario' => '',
          'primerapellidodestinatario' => $request->apellido1Tercero,
          'segundoapellidodestinatario' => $request->apellido2Tercero,
          'razonsocialdestinatario' => $request->razonSocialTercero,
          'naturalezadestinatario' => '',
          'direcciondestinatario' => $sucursal['direcciondestinatario'],
          'telefonodestinatario' =>  $sucursal['telefonodestinatario'],
          'ciudaddestinatario' => '11001000',//$sucursal['ciudaddestinatario']
          'barriodestinatario' => '',
          'totalpeso' => '',
          'totalpesovolumen' => '',
          'formapago' => '',
          'observaciones' => isset($sucursal['observacion']) ? $sucursal['observacion']: '',
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
          'generarDocumentos' => 'true',
          'unidadesinternas' => '',
          'fuente' => '',
          'txt' => ''
        ];
        //Se organiza la informacion del plano con respecto a la estructura estipulada por tcc
        $data = $this->replaceData($data);
        //Se inicializa el cliente de nusoap
        $nusoap_client = new nusoap_client('http://clientes.tcc.com.co/preservicios/wsdespachos.asmx?wsdl', 'wsdl');
        $nusoap_client->soap_defencoding = 'UTF-8';
        $nusoap_client->version = SOAP_1_2;
        $err = $nusoap_client->getError();
        //Se intenta mandar el servicio pero nos responde con un error
        $response = $nusoap_client->call('GrabarDespacho4', array("literal" => $data['txt']), '', 'http://clientes.tcc.com.co/GrabarDespacho4',false, null,'document','literal');
        return response()->json($response);

        $message .= $response['printTipoError'];
      }

      $res = compact('message','data');
      return response()->json($res);

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

      $documento .= '      <fuente>'.'</fuente>'.chr(13) . chr(10);
      $documento .= '     </cli:objDespacho>'.chr(13) . chr(10);
      $documento .= '     <cli:remesa>0</cli:remesa>'.chr(13) . chr(10);
      $documento .= '     <cli:URLRelacionEnvio></cli:URLRelacionEnvio>'.chr(13) . chr(10);
      $documento .= '     <cli:URLRotulos></cli:URLRotulos>'.chr(13) . chr(10);
      $documento .= '     <cli:URLRemesa></cli:URLRemesa>'.chr(13) . chr(10);
      $documento .= '     <cli:IMGRelacionEnvio></cli:IMGRelacionEnvio>'.chr(13) . chr(10);
      $documento .= '     <cli:IMGRotulos></cli:IMGRotulos>'.chr(13) . chr(10);
      $documento .= '     <cli:IMGRemesa></cli:IMGRemesa>'.chr(13) . chr(10);
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
      //objDespacho del xml
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
        //Unidades del documento
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
        //documentosReferencia del documento
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
