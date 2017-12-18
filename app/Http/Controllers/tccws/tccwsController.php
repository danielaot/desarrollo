<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BESA\VInformacionEmpaqueFacturaDoctos as FactuClientes;
use App\Models\SCPRD\VInformacionEmpaqueFactura as InfoCargoFactura;
use App\Models\tccws\TDoctoDespachostcc as EstructuraDocto;
use App\Models\tccws\TClientesBoomerang as ClientesBoomerang;
use App\Models\tccws\TRemesa;
use App\Models\tccws\TFactsxremesa;
use App\Models\tccws\TParametros;
use App\Models\tccws\TCiudadestcc;
use App\Models\wms\UPL_ORDERS;
use App\Models\wms\UPL_ORDESP;
use App\Models\DigitacionRemesas\TRemesa as DigiRemesa;
use App\Models\DigitacionRemesas\TDetfacremesa as DetFactRemesa;
use App\Models\DigitacionRemesas\TRelciudadestcc as RelacionCiudades;
use App\Models\Genericas\TCliente;
use Carbon\Carbon;
use App\Models\Genericas\Tercero;
use DB;
use nusoap_client;
use Illuminate\Support\Facades\Auth;
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
        $facturas = FactuClientes::select('fecha_remesa' ,'num_oc', 'num_ciudad',
        'txt_direccion', 'txt_telefono', 'desc_ciudad', 'desc_departamento',
        'num_factura', 'tipo_docto', 'num_consecutivo',
        'nom_tercero', 'num_sucursal', 'desc_sucursal',
        'nit_tercero', 'date_creacion','tipoPedido')
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

    public function excluirDocumentos(Request $request){

      $data = $request->all();
      $facturasParaRemesas = [];
      $data['sucursalesFiltradas'] = [];
      $data['documentosExcluir']= [];
      $sucursales = collect($data['sucursales']);

      $data['sucursalesFiltradas'] = $sucursales->filter(function($sucuMap){
        return $sucuMap['hasOneOrMoreSelected'] == true;
      })->values();

      foreach ($data['sucursalesFiltradas'] as $key => $sucursal) {
          foreach ($sucursal['facturasAEnviar'] as $key => $factura) {
            array_push($facturasParaRemesas, $factura);
          }
      }

      $arrayFactsGroup = collect($facturasParaRemesas);
      $data['facturasSucursales'] = collect($arrayFactsGroup)->groupBy('num_sucursal');

      foreach ($data['sucursalesFiltradas'] as $key => $sucursal) {

        foreach ($data['facturasSucursales'][$sucursal['codigo']] as $key => $factura) {

          if(strlen($factura['tipo_docto']) < 3){
            $factura['tipo_docto'] = str_pad($factura['tipo_docto'],3," ", STR_PAD_RIGHT);
          }
          $formatoDocumento = $factura['tipo_docto'].'-'.$factura['num_consecutivo'];

          array_push($data['documentosExcluir'], array(
            'tipoPedido' => trim($factura['tipoPedido']),
            'formatoDocumento' => $formatoDocumento
          ));

        }

      }

      $documentosExcluidosResponse = $this->cleanUplOrders($data['documentosExcluir'],false,"EXCLUIDATCCWS");
      return response()->json($documentosExcluidosResponse);

    }

    public function getUnidadesLogisticas(Request $request){

      $data = $request->all();
      $facturasParaRemesas = [];
      $data['sucursalesFiltradas'] = [];
      $sucursales = collect($data['sucursales']);

      $existeCliente = ClientesBoomerang::where('clb_idTercero', $data['idTercero'])->get();

      if(count($existeCliente) > 0){
        $data['tieneBoomerang'] = true;
      }

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
        $sucursal['unidadBoomerang'] = [];
        $sucursal['tieneBoomerang'] = false;

        if(isset($data['tieneBoomerang']) && $data['tieneBoomerang'] == true){
          $sucursal['tieneBoomerang'] = true;
        }
        //Se obtiene la informacion de la sucursal desde las facturas agrupadas por sucursal
        $sucursal['direcciondestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['txt_direccion'];
        $sucursal['telefonodestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['txt_telefono'];
        $sucursal['ciudaddestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['desc_ciudad'];
        $sucursal['sededestinatario'] = $data['facturasSucursales'][$sucursal['codigo']][0]['desc_sucursal'];


        //Se hace un recorrido por cada factura de una sucursal
        foreach ($data['facturasSucursales'][$sucursal['codigo']] as $key => $factura) {

          if(strlen($factura['tipo_docto']) < 3){
            $factura['tipo_docto'] = str_pad($factura['tipo_docto'],3," ", STR_PAD_RIGHT);
          }

          $formatoDocumento = $factura['tipo_docto'].'-'.$factura['num_consecutivo'];
          //Guardamos los documentos de referencia que iran en el plano que se envia a tcc
            array_push($sucursal['documentosReferencia'], array(
              'tipoPedido' => trim($factura['tipoPedido']),
              'numeroOrdenCompra' => trim($factura['num_oc']),
              'tipodocumento' => trim($factura['tipo_docto']),
              'numerodocumento' => $factura['num_consecutivo'],
              'formatoDocumento' => $formatoDocumento,
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

        if($sucursal['tieneBoomerang'] == true){

              $sucursal['unidadBoomerang'] = array(
                "tipounidad" => "TIPO_UND_DOCB",
                "claseempaque" => 'CLEM_CAJA',
                "tipoempaque" => '',
                "dicecontener" => '',
                "cantidadunidades" => 1,
                "kilosreales" => 0,
                "kilosrealestcc" => 0,
                "largo" => 0,
                "alto" => 0,
                "ancho" => 0,
                "pesovolumen" => 0,
                "valormercancia" => 0,
                "codigobarras" => '',
                "numerobolsa" => '',
                "referencias" => '',
                "unidadesinternas" => ''
              );

        }


        return $sucursal;
      });

      return response()->json($data);

    }


    public function getPlano(Request $request){

      $message = [];
      $parametrosDefault = [];
      $parametrosDefaultConsulta = TParametros::where('par_grupo', 'a')->get();

      foreach ($parametrosDefaultConsulta as $key => $parametro) {
        $parametrosDefault[$parametro['par_campoVariable']] = $parametro['par_valor'];
      }

      extract($parametrosDefault);

      //Se organiza el plano por cada sucursal
      foreach ($request->sucursalesFiltradas as $key => $sucursal) {
        //Se obtienen solo las unidades logisticas las cuales su cantidad en unidades es mayor a '0'
        $sucursal['unidades'] = collect($sucursal['unidades'])->filter(function($unidad){
          return $unidad['cantidadunidades'] > 0;
        })->values();

        $sucursal['unidades']= collect($sucursal['unidades'])->map(function($unidad){
          if($unidad['claseempaque'] == "CLEM_CAJA"){
              $unidad['kilosrealestcc'] = $unidad['kilosreales'];
          }elseif($unidad['claseempaque'] == "CLEM_LIO"){
              $unidad['kilosrealestcc'] = $unidad['kilosreales'] / $unidad['cantidadunidades'];
          }elseif($unidad['claseempaque'] == "CLEM_PALET"){
            $unidad['kilosrealestcc'] = $unidad['kilosreales'] / $unidad['cantidadunidades'];
          }

          return $unidad;
        });

        $codigoDaneTcc = TCiudadestcc::where('ctc_ciu_erp',$sucursal['ciudaddestinatario'])->get();

        if(count($codigoDaneTcc) == 0){
          $message = array("nombreSucursal"=> $sucursal['nombre'],"mensaje" => "Se ha presentado un error con la ciudad del destinatario, por favor comuniquese con el area de sistemas.", "respuesta" => "ciu_error", "remesa" => "0");
          return response()->json(["message" => $message],202);
        }

        $documentosString = collect($sucursal['documentosReferencia'])->pluck('formatoDocumento')->all();
        $documentosString = implode(", ",$documentosString);

        if(isset($sucursal['observacion'])){
          $sucursal['observacion'] .= "\nDocumentos de facturas enviadas para esta remesa: ".$documentosString.".";
        }else{
          $sucursal['observacion'] = "Documentos de facturas enviadas para esta remesa: ".$documentosString.".";
        }

        $data = [
          'clave' => $clave,
          'codigolote' => '',
          'fechahoralote' => '',
          'numeroremesa' => '',
          'numeroDepacho' => '',
          'unidadnegocio' => '1',
          'fechadespacho' => Carbon::today()->toDateString(),
          'cuentaremitente' => $cuentaremitente,
          'sederemitente' => '',
          'primernombreremitente' => $primernombreremitente,
          'segundonombreremitente' => '',
          'primerapellidoremitente'=> '',
          'segundoapellidoremitente'=> '',
          'razonsocialremitente'=> $razonsocialremitente,
          'naturalezaremitente' => $naturalezaremitente,
          'tipoidentificacionremitente' => $tipoidentificacionremitente,
          'identificacionremitente' => $identificacionremitente,
          'telefonoremitente' => $telefonoremitente,
          'direccionremitente'=> $direccionremitente,
          'ciudadorigen' => $ciudadorigen,
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
          'ciudaddestinatario' => $codigoDaneTcc[0]['ctc_cod_dane'],//$sucursal['ciudaddestinatario']
          'barriodestinatario' => '',
          'totalpeso' => '',
          'totalpesovolumen' => '',
          'formapago' => '',
          'observaciones' => $sucursal['observacion'],
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
          'generarDocumentos' => $generarDocumentos,
          'unidadesinternas' => '0',
          'fuente' => '',
          'txt' => '',
          'unidadBoomerang' => $sucursal['unidadBoomerang']
        ];

        //Se organiza la informacion del plano con respecto a la estructura estipulada por tcc
        $data = $this->replaceData($data);
        $data['tieneBoomerang'] = false;
        return response()->json($data['txt']);
        //Se envia el xml al servicio de tcc
        $responseRemesa = $this->consumirServicioTcc($data['txt']);
        $xmlResponseBody = array("mensaje" => $responseRemesa['mensaje'], "respuesta" => $responseRemesa['respuesta'], "remesa" => $responseRemesa['remesa']);
        $xmlResponseBody['nombreSucursal'] = $sucursal['nombre'];


        if($xmlResponseBody['respuesta'] == 0){
          $xmlResponseBody['respuesta'] = "success";
          $grabarEnTablas = $this->poblarTablasRemesas($sucursal,$xmlResponseBody,false);

          if($sucursal['tieneBoomerang'] == true){
            $data['tieneBoomerang'] = true;
            $data = $this->replaceData($data,true);
            //Se envia el xml de un boomerang al servicio de tcc
            $responseBoomerang = $this->consumirServicioTcc($data['txt']);
            $xmlResponseBody['boomerangResponse'] = array("mensaje" => $responseBoomerang['mensaje'], "respuesta" => $responseBoomerang['respuesta'], "remesa" => $responseBoomerang['remesa']);
            $this->poblarTablasRemesas($sucursal,$xmlResponseBody['boomerangResponse'],true,$grabarEnTablas);
          }

        }else{
          if($xmlResponseBody['respuesta'] < 0){
            $xmlResponseBody['respuesta'] = "error_normal";
          }elseif($xmlResponseBody['respuesta'] == 1){
            $xmlResponseBody['respuesta'] = "error_acceso";
          }
        }

        array_push($message,$xmlResponseBody);
      }

      $res = compact('message','data');
      return response()->json($res,200);

    }

    public function poblarTablasRemesas($sucursal,$xmlResponseBody,$isBoomerang,$remesaPadre = null){

      $remesaTabla = new TRemesa;
      $remesaTabla->rms_remesa = $xmlResponseBody['remesa'];
      $remesaTabla->rms_observacion = isset($sucursal['observacion']) ? $sucursal['observacion']: '';
      $remesaTabla->rms_terceroid = $sucursal['nit_tercero'];
      $remesaTabla->rms_sucu_cod = $sucursal['codigo'];
      $remesaTabla->rms_ciud_sucursal = $sucursal['ciudaddestinatario'];
      $remesaTabla->rms_nom_sucursal = $sucursal['nombre'];
      $remesaTabla->rms_cajas = $isBoomerang == true ? $sucursal['unidadBoomerang']['cantidadunidades'] : 0;
      $remesaTabla->rms_lios =  0;
      $remesaTabla->rms_pesolios = 0;
      $remesaTabla->rms_pesoliostcc = 0;
      $remesaTabla->rms_palets = 0;
      $remesaTabla->rms_pesopalets = 0;
      $remesaTabla->rms_pesopaletstcc = 0;
      $remesaTabla->rms_remesapadre = $remesaPadre != null ? $remesaPadre->id : null;
      $remesaTabla->rms_isBoomerang = $isBoomerang == true ? true : false;
      $remesaTabla->rms_pesototal = 0;

      if($isBoomerang == false){
        foreach ($sucursal['unidades'] as $key => $unidad) {

          if($unidad['claseempaque'] == "CLEM_CAJA"){
            $remesaTabla->rms_cajas = $unidad['cantidadunidades'];
          }else if($unidad['claseempaque'] == "CLEM_LIO"){
            $remesaTabla->rms_lios = $unidad['cantidadunidades'];
            $remesaTabla->rms_pesolios = $unidad['kilosreales'];
            $remesaTabla->rms_pesoliostcc = $unidad['kilosrealestcc'];
          }else if($unidad['claseempaque'] == "CLEM_PALET"){
            $remesaTabla->rms_palets = $unidad['cantidadunidades'];
            $remesaTabla->rms_pesopalets = $unidad['kilosreales'];
            $remesaTabla->rms_pesopaletstcc = $unidad['kilosrealestcc'];
          }
        }
        $remesaTabla->rms_pesototal = $sucursal["sumaTotalKilos"];
        $remesaTabla->save();

        foreach ($sucursal['documentosReferencia'] as $key => $documento) {
          $facturaRemesa = new TFactsxremesa;
          $facturaRemesa->fxr_remesa = $remesaTabla->id;
          $facturaRemesa->fxr_tipodocto = $documento['tipodocumento'];
          $facturaRemesa->fxr_numerodocto = $documento['numerodocumento'];
          $facturaRemesa->fxr_fechadocto = Carbon::parse($documento['fechadocumento'])->toDateString();
          $facturaRemesa->save();
        }

        $responseMessage = $this->cleanUplOrders($sucursal['documentosReferencia'],false,$xmlResponseBody['remesa']);

      }else{
        $remesaTabla->save();
      }

      $tablasDigitacionResponse = $this->poblarTablasDigitacion($remesaTabla,$sucursal);
      return $remesaTabla;
    }

    public function poblarTablasDigitacion($remesa,$sucursal){

      $parametrosDefault = [];
      $parametrosDefaultConsulta = TParametros::whereIn('par_grupo', ['otro','a'])->get();
      foreach ($parametrosDefaultConsulta as $key => $parametro) {
        $parametrosDefault[$parametro['par_campoVariable']] = $parametro['par_valor'];
      }
      extract($parametrosDefault);

      $userLogged = Auth::user();
      $ciudadDestinatario = RelacionCiudades::where('rel_txt_ciudad', $remesa->rms_ciud_sucursal)
      ->with('ciudadtcc')->first();
      $sucursalesDestinatario = TCliente::where('ter_id',$remesa->rms_terceroid)->with('sucursalestcc')->first();

      $sucursalRemesaGenericas = collect($sucursalesDestinatario['sucursalestcc'])->filter(function($sucursal) use($remesa){
        return trim($sucursal['suc_num_codigo']) == trim($remesa->rms_sucu_cod);
      })->values();

      $remesaDigi = new DigiRemesa;
      $remesaDigi->ciu_id = $ciudadDestinatario['ciudadtcc']['ciu_id'];
      $remesaDigi->ter_id_crea = $userLogged['idTerceroUsuario'];
      $remesaDigi->tra_id = $codigoTransportador;
      $remesaDigi->rem_dat_creacion = Carbon::parse($remesa['created_at'])->format('Ymd');
      $remesaDigi->rem_num_codigo = $remesa->rms_remesa;
      $remesaDigi->rem_num_tipodespacho = $remesa->rms_isBoomerang == false ? 1 : 2;
      $remesaDigi->rem_num_cuentaremite = $cuentaremitente;
      $remesaDigi->ter_id = $remesa->rms_terceroid;
      $remesaDigi->suc_id = $sucursalRemesaGenericas[0]['suc_id'];
      $remesaDigi->suc_txt_descripcion = $sucursalRemesaGenericas[0]['suc_txt_nombre'];
      $remesaDigi->ter_txt_descripcion = $sucursal['facturas'][0]['nom_tercero'];
      $remesaDigi->ter_txt_direccion = $sucursalRemesaGenericas[0]['suc_txt_direccion'];
      $remesaDigi->ter_num_telefono = $sucursalRemesaGenericas[0]['suc_txt_telefono'];
      $remesaDigi->ter_txt_ciudad = $sucursalRemesaGenericas[0]['suc_txt_ciudad'];
      $remesaDigi->rem_num_tipodocumento = $tipoDocumento;
      $remesaDigi->rem_ltxt_observaciones = $remesa['rms_observacion'];
      $remesaDigi->rem_num_unidades = $remesa['rms_lios'] + $remesa['rms_palets'];
      $remesaDigi->rem_num_estibas = $remesa['rms_palets'];
      $remesaDigi->rem_num_lios = $remesa['rms_lios'];
      $remesaDigi->rem_num_cajas = $remesa['rms_cajas'];
      $remesaDigi->rem_num_kilos = $remesaNumKilos;
      $remesaDigi->rem_num_totalkilos = $remesa['rms_pesototal'];
      $remesaDigi->rem_dat_entrega = null;
      $remesaDigi->rem_num_estado = $estadoRemesa;
      $remesaDigi->rem_num_factura = null;
      $remesaDigi->rem_num_flete = null;
      $remesaDigi->rem_num_porflete = null;
      $remesaDigi->rem_num_estadotrans = null;
      $remesaDigi->rem_txt_estadotrans = null;
      $remesaDigi->cau_id = null;
      $remesaDigi->suc_num_codigoenvio = $sucursalRemesaGenericas[0]['suc_num_codigoenvio'];
      $remesaDigi->suc_num_codigoenvio = $sucursalRemesaGenericas[0]['suc_num_codigoenvio'];
      $remesaDigi->rem_date_fechahora = strtotime($remesa['created_at']);
      $remesaDigi->rem_date_fechacorte = strtotime($remesa['created_at']);
      $remesaDigi->save();

      foreach ($sucursal['documentosReferencia'] as $key => $documento) {
        $facturaRemesa = new DetFactRemesa;
        $facturaRemesa->rem_id = $remesaDigi->rem_id;
        $facturaRemesa->det_num_tipodocto = $documento['tipodocumento'];
        $facturaRemesa->det_num_factura = $documento['numerodocumento'];
        $facturaRemesa->det_dat_vencimiento1 = Carbon::parse($remesa['created_at'])->format('Ymd');
        $facturaRemesa->det_dat_vencimiento2 = Carbon::parse($remesa['created_at'])->addDays(2)->format('Ymd');
        $facturaRemesa->det_txt_valorfactura = 0;
        $facturaRemesa->det_num_unidadesfactura = 0;
        $facturaRemesa->det_num_itemsfactura = 0;
        $facturaRemesa->can_id = $sucursalRemesaGenericas[0]['codcanal'];
        $facturaRemesa->save();
      }

      return $remesaDigi;
    }

    public function replaceData($data,$isBoomerang = false){

      extract($data);
      $documento =  '<?xml version="1.0" encoding="utf-8"?>'.chr(13) . chr(10);
      $documento .= '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:cli="http://clientes.tcc.com.co/">'.chr(13) . chr(10);
      $documento .= ' <soap:Header/>'.chr(13) . chr(10);
      $documento .= '  <soap:Body>'.chr(13) . chr(10);
      $documento .= '   <cli:GrabarDespacho4>'.chr(13) . chr(10);
      $documento .= '     <cli:objDespacho>'.chr(13) . chr(10);

      $grupos = collect($estructura)->unique('ddt_grupo')->values();
      $grupos = collect($grupos)->pluck('ddt_grupo');
      foreach ($grupos as $key => $grupo) {
          $listado = collect($estructura)->where('ddt_grupo',$grupo)->sortBy('ddt_orden');
          $documento .= $this->replaceMvts($grupo,$listado,$data,$isBoomerang);
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


    public function replaceMvts($grupo,$listado,$data,$isBoomerang = false){

      extract($data);
      $documento = '';
      $metaDocto = '';
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
        $cantidadCajas = 0;
        $yaEntro = 0;

        if($isBoomerang == false){

            foreach ($unidades as $key => $unidad) {

              if($yaEntro == 0 && $unidad['claseempaque'] == "CLEM_CAJA"){
                  $cantidadCajas = $unidad['cantidadunidades'];
                  $yaEntro += 1;
              }

              if($unidad['claseempaque'] != "CLEM_CAJA"){

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
                $cantidadCajas = 0;
              }
            }

        }else{
          extract($unidadBoomerang);
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

          // if($isBoomerang == false){
          //   $metaDocto = "documentosReferencia";
          // }else{
          //   $metaDocto = "documentoreferencia";
          // }

          $metaDocto = "documentoreferencia";

          $documento .= '      <'.$metaDocto.'>'.chr(13) . chr(10);
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
          $documento .= '      </'.$metaDocto.'>'.chr(13) . chr(10);
        }
        return $documento;

      }
    }

    public function limpiarXML($xml){

      $toRemove = ['env', 'cli', 'soap', 'wsse', 'xsi', 'xsd', 'wsa', 'wsu'];

      foreach( $toRemove as $remove ) {
          $xml = str_replace('<' . $remove . ':', '<', $xml);
          $xml = str_replace('</' . $remove . ':', '</', $xml);
      }

      return $xml;
    }

    public function consumirServicioTcc($xml){

      //Se inicializa el cliente de nusoap
      $nusoap_client = new nusoap_client('http://clientes.tcc.com.co/preservicios/wsdespachos.asmx?wsdl', true);
      $nusoap_client->soap_defencoding = 'UTF-8';
      $nusoap_client->decode_utf8 = false;
      //$nusoap_client->version = SOAP_1_1;
      $nusoap_client->operation = "GrabarDespacho4";
      $err = $nusoap_client->getError();

      //Se envia el archivo plano en formato xml al servicio de tcc
      $nusoap_client->send($xml,'http://clientes.tcc.com.co/GrabarDespacho4',300,300);

      $xmlResponse = $nusoap_client->responseData;
      $xmlResponse = json_decode(json_encode(simplexml_load_string($this->limpiarXML($xmlResponse))),true);
      $xmlResponseBody = $xmlResponse['Body']['GrabarDespacho4Response'];

      return $xmlResponseBody;

    }

    public function cleanUplOrders($facturas,$isFound = false,$mensaje = ""){

      $uplOrder = [];
      // AGRUPO LAS FACTURAS POR EL TIPO DE PEDIDO
      $tiposPedidos = collect($facturas)->groupBy('tipoPedido')->values();

      try{

        foreach ($tiposPedidos as $key => $tipoPedido) {
          // REALIZO UN PLUCK A CADA UNO DE LOS GRUPOS POR EL FORMATO DE DOCUMENTO
          $codigosFacturas = $tipoPedido->pluck('formatoDocumento')->values()->all();
          // REALIZO EL UPDATE SOBRE CADA FACTURA EN LA TABLA CORRESPONDIENTE SEGUN EL TIPO DE PEDIDO
          if($tipoPedido[0]['tipoPedido'] == "N"){
            foreach ($codigosFacturas as $key => $value) {
              $uplOrder = UPL_ORDERS::where('A29', $value)->update(['A19' => $mensaje.'TPN']);
            }
          }elseif($tipoPedido[0]['tipoPedido'] == "P"){
            foreach ($codigosFacturas as $key => $value) {
              $uplOrder = UPL_ORDESP::where('A29', $value)->update(['A19' => $mensaje.'TPP']);
            }
          }

        }

      }catch(Exception $e){
        return "Se ha presentado un error al intentar actualizar los campos de la base de datos ".$e;
      }

      return "Se han excluido correctamente todos los documentos";
    }

    public function getConsultaRemesas()
    {
      $ruta = "SGA // CONSULTAR REMESA";
      $titulo = "Consultar remesa";
      $response = compact('ruta', 'titulo');
      return view('layouts.tccws.Catalogos.consultaDeRemesas', $response);
    }

    public function consultaRemesasGetInfo()
    {
      $consultafacturas = TFactsxremesa::where('created_at', '>', Carbon::now()->subDays(3))->with('consulta', 'consulta.facturas', 'consulta.boomerang', 'consulta.nombreCliente')->get();
      $response = compact('consultafacturas');
      return response()->json($response);
    }

    public function consultaBusquedasGetInfo(Request $request)
    {
      $prueba = $request->all();
      $prueba['busqueda'] = trim($prueba['busqueda']);
      if ($prueba['radio'] == "facturas") {
        $consultaremesas = TFactsxremesa::with('consulta', 'consulta.facturas', 'consulta.boomerang', 'consulta.nombreCliente')->where('fxr_numerodocto', $prueba['busqueda'])->get();
      }else{
        $consultaremesas = TFactsxremesa::with('consulta', 'consulta.facturas', 'consulta.boomerang', 'consulta.nombreCliente')->whereHas('consulta', function($query) use($prueba){
            $query->where('rms_remesa', $prueba['busqueda']);
        })->get();
      }
        $response = compact('consultaremesas', 'prueba');
        return response()->json($response);
    }

    public function consultaFechasGetInfo(Request $request)
    {
      $fech = $request->all();
      $fech['inicial'] = Carbon::parse($fech['inicial'])->subHour(5);
      $fech['final'] = Carbon::parse($fech['final'])->addHour(19);

      $consultafechas = TFactsxremesa::with('consulta', 'consulta.facturas', 'consulta.boomerang', 'consulta.nombreCliente')->whereBetween('created_at', [$fech['inicial'], $fech['final']])->get();
      $response = compact('consultafechas', 'fech');
      return response()->json($response);
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
