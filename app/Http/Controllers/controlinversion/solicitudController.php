<?php

namespace App\Http\Controllers\controlinversion;

use App\Models\controlinversion\TSolicitudctlinv;
use App\Models\controlinversion\TSolicliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\controlinversion\autorizacionController as AutorizacionCtrl;
use App\Models\BESA\lineasProducto;
use App\Models\controlinversion\TFacturara;
use App\Models\controlinversion\TTiposalida;
use App\Models\controlinversion\TTipopersona;
use App\Models\controlinversion\TCargagasto;
use App\Models\controlinversion\TLineascc;
use App\Models\controlinversion\TSolipernivel;
use App\Models\controlinversion\TPerniveles;
use App\Models\controlinversion\TSolhistorico;
use App\Models\controlinversion\TCanalpernivel;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TCanal;
use App\Models\Genericas\TItemCriteriosTodo;
use App\Models\BESA\VendedorZona;
use App\Models\BESA\PreciosReferencias;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Mail;
use App\Mail\notificacionEstadoSolicitud;


ini_set('max_execution_time', 300);


class solicitudController extends Controller
{

    /**
     * Consulta y retorna a la vista en formato JSON, Cargue Inicial
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function solicitudGetInfo()
    {


        $userLogged = Auth::user();
        $rutaNoAutoriza = route('misSolicitudes');

        $personas = TFacturara::with('tercero')->get();

        $tiposalida = TTiposalida::where('tsd_estado', '1')->get();

        $tipopersona = TTipopersona::where('tpe_estado', '1')->whereIn('tpe_id',[1,3])->get();

        $cargagasto = TCargagasto::where('cga_estado', '1')->get();

        $lineasproducto = TLineascc::with('LineasProducto')->where('lcc_centrocosto','!=','0')->get();

        $pruebita = TSolicliente::with('clientesZonas')->get();

        $canales = TCanal::whereIn('can_id', ['20','AL','DR'])->get();

        $fullUser = TPerniveles::where('pern_cedula', $userLogged->idTerceroUsuario)->get();

        $canalPernivel =  TCanalpernivel::all();


        $colaboradores = Tercero::select('idTercero','idTercero as scl_cli_id', 'razonSocialTercero as scl_nombre')->with('Cliente.Sucursales')->where([['indxEstadoTercero', '1'], ['indxEmpleadoTercero', '1']])->orderBy('razonSocialTercero')->get();
        $colaboradores = $colaboradores->filter(function($value, $key){
            return ($value['Cliente'] != null && $value['Cliente']['Sucursales'] != null && count($value['Cliente']['Sucursales']) > 0 && strlen($value['idTercero']) > 5);
        })->values();

        $vendedoresBesa= VendedorZona::select('NitVendedor as scl_cli_id', 'NomVendedor as scl_nombre', 'NomZona', 'CodZona as scz_zon_id')->where('estado', 1)->get();

        $item = TItemCriteriosTodo::select('ite_referencia as srf_referencia',
        'ite_descripcion as referenciaDescripcion',
        'ite_nom_estado as srf_estadoref',
        'ite_nom_linea as referenciaLinea',
        'ite_cod_linea as srf_lin_id_gasto')
        ->with('LineaItemCriterio')
        ->where('ite_cod_tipoinv', '1051')
        ->get();

        $response = compact('personas','tiposalida', 'tipopersona', 'cargagasto', 'lineasproducto', 'colaboradores', 'users', 'item', 'vendedoresBesa', 'userLogged', 'pruebita', 'canales', 'fullUser', 'rutaNoAutoriza' , 'canalPernivel');
        return response()->json($response);
    }



    public function consultarInformacionReferencia(Request $request){

      $data = $request->all();
      $infoRefe = PreciosReferencias::consultarReferencia($data['srf_referencia']);
      $response = compact('infoRefe');
      return response()->json($response);

    }


    public function consultarInformacionReferencias(Request $request){

      $infoRefes = PreciosReferencias::consultarReferencias($request);
      $response = compact('infoRefes');
      return response()->json($response);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $ruta = 'Control de Inversion // Crear Solicitud';
        $titulo = 'CREAR SOLICITUD';

        return view('layouts.controlinversion.solicitud.formsolicitud', compact('ruta','titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $routeSuccess = route('misSolicitudes');
        $data = $request->all();

        $solicitudToCreate = $this->guardarSolicitud($data);
        $response = compact('solicitudToCreate', 'routeSuccess');
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
      $ruta = 'Control de Inversion // Editar Solicitud';
      $titulo = 'EDITAR SOLICITUD';
      $solicitud = TSolicitudctlinv::with('clientes.clientesReferencias','clientes.clientesReferencias.referencia.LineaItemCriterio','clientes.clientesZonas', 'clientes.clientesReferencias.referencia')->where('sci_id', $id)->get();
      $solicitud[0]['sci_soe_id'] = 1;

      $response = compact('ruta', 'titulo', 'solicitud');

      return view('layouts.controlinversion.solicitud.formsolicitud', $response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function correciones($id)
    {
      $ruta = 'Control de Inversion // Corregir Solicitud';
      $titulo = 'CORRECIÓN DE SOLICITUD';
      $solicitud = TSolicitudctlinv::with('clientes.clientesReferencias','clientes.clientesReferencias.referencia.LineaItemCriterio','clientes.clientesZonas')->where('sci_id', $id)->get();
      $solicitud[0]['isCorrecion'] = true;
      $response = compact('ruta', 'titulo', 'solicitud');

      return view('layouts.controlinversion.solicitud.formsolicitud', $response);
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

        $data = $request->all();
        $routeSuccess = route('misSolicitudes');
        $solicitudPorNivel = [];
        $solicitudPrincipal = [];

        $solicitudPorNivel = TSolipernivel::with('tpernivel.tperjefe')->where('sni_usrnivel', $data['userNivel'][0]['id'])
        ->where('sni_sci_id',$id)->get();

      //  dd($solicitudPorNivel);



        //Actualiza la información de la solicitud
        if($data['accion'] == "Actualizar"){

          $solicitudPrincipal = TSolicitudctlinv::find($id)->update($data);
        }
        //Secuencia guardar y enviar, ingresa primero a crear la solicitud y por consiguiente continua a aprobación inmediatamente
        if($data['accion'] == "Crear"){

          //Se obtiene la información de la solicitud enviada para ejecutar las transacciones de creación y actualización
          $dataSolicitudToCreate = $data;
          $dataSolicitudToUpdate = $data; //La solicitud que viene desde el boton guardar y enviar por defecto viene en estado solicitud(1)
          $dataSolicitudToCreate['sci_soe_id'] = 0; //El estado de una solicitud en creación debe ser 0 porque estaria en principio en estado EN ELABORACION
          $solicitudAEnviar = $this->guardarSolicitud($dataSolicitudToCreate);//Se crea la solicitud en estado 0
          /**
          *Buscamos la ruta de aprobación existente para esta solicitud, en este momento la solicitud esta en creación
          *Por ende se busca por el id de la solicitud y el id del usuario que esta creando la solicitud
          *Cabe aclarar que este usuario debe estar registrado en la tabla t_perniveles
          */
          $solicitudPorNivel = TSolipernivel::with('tpernivel.tperjefe')->where('sni_usrnivel', $data['userNivel'][0]['id'])
          ->where('sni_sci_id',$solicitudAEnviar->sci_id)->get();
          //Se cambia la acción para que pueda continuar al paso siguiente que es el de aprobación
          $data['accion'] = "Aprobar";

        }

        if($data['accion'] == "Aprobar"){
          /*
          *Si una solicitud esta en creación al ejecutar guardar y enviar el id de la solicitud todavia no existe
          *Por ende viene undefined y con esta validación al id se le asigna el id de la solicitud que se creo en el
          *Paso anterior de Crear
          */
          if($id != "undefined"){
            $id = $id;
          }elseif($id == "undefined" && isset($solicitudAEnviar->sci_id)){
            $id = $solicitudAEnviar->sci_id;
          }

          //Actualizamos la solicitud para que este en estado de Solicitud(1) en secuencia de Enviar
          $solicitudPrincipal = TSolicitudctlinv::find($id)->update($data);//Se pasa data porque su estado originalmente desde la vista viene en Solicitud(1)

          //Pasos de envio de personas de nivel 1
          if($solicitudPorNivel[0]['tpernivel']['pern_nomnivel'] == 1){

            $solicitudPorNivelPendiente =  TSolipernivel::find($solicitudPorNivel[0]['id']);
            $solicitudPorNivelPendiente->sni_estado = 1;
            $solicitudPorNivelPendiente->save();

            $nuevaSolicitudPorNivel = new TSolipernivel;
            $nuevaSolicitudPorNivel->sni_usrnivel = $solicitudPorNivel[0]['tpernivel']['tperjefe']['id'];
            $nuevaSolicitudPorNivel->sni_cedula = $solicitudPorNivel[0]['tpernivel']['tperjefe']['pern_cedula'];
            $nuevaSolicitudPorNivel->sni_sci_id = $id;
            $nuevaSolicitudPorNivel->sni_estado = 0;
            $nuevaSolicitudPorNivel->sni_orden = null;
            $nuevaSolicitudPorNivel->save();

            $registroHistorico = new TSolhistorico;
            $registroHistorico->soh_sci_id = $id;
            $registroHistorico->soh_soe_id = $data['sci_soe_id'];
            $registroHistorico->soh_idTercero_envia = $data['userNivel'][0]['pern_cedula'];
            $registroHistorico->soh_idTercero_recibe = $solicitudPorNivel[0]['tpernivel']['tperjefe']['pern_cedula'];

            if(isset($data['sci_observaciones'])){

              if($data['sci_observaciones'] != null && trim($data['sci_observaciones']) != ""){
                $registroHistorico->soh_observacion = $data['sci_observaciones'];
              }else{
                $registroHistorico->soh_observacion = "ENVIO DE SOLICITUD";
              }

            }else{
              $registroHistorico->soh_observacion = "ENVIO DE SOLICITUD";
            }

            $registroHistorico->soh_fechaenvio = Carbon::now();
            $registroHistorico->soh_estadoenvio = 1;
            $registroHistorico->save();

            $dataSolicitud = TSolhistorico::with('perNivelEnvia', 'perNivelRecibe', 'estado', 'solicitud', 'solicitud.clientes', 'solicitud.clientes.clientesReferencias', 'solicitud.clientes.clientesReferencias.referencia', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio.LineasProducto', 'solicitud.cargaralinea', 'solicitud.cargaralinea.LineasProducto')->where('soh_id',$registroHistorico->soh_id)->first();

            $correo = ['omolaya@bellezaexpress.com'];
            Mail::to($correo)->send(new notificacionEstadoSolicitud($dataSolicitud));

            if(Mail::failures()){
                return response()->json(Mail::failures());
            }

          }else if($solicitudPorNivel[0]['tpernivel']['pern_nomnivel'] == 2){

             $dataNivel2 = $data;
             $dataNivel2['sci_id'] = $id;
             $autorizacionSolicitud = AutorizacionCtrl::store($request, $id, true);
             //dd($autorizacionSolicitud);
             //return response()->json($autorizacionSolicitud);

          }else if($solicitudPorNivel[0]['tpernivel']['pern_nomnivel'] == 3){

            $dataNivel3 = $data;
            $dataNivel3['sci_id'] = $id;
            $autorizacionSolicitud = AutorizacionCtrl::store($request, $id, true);

            // return response()->json(['message'=> 'nivel3 autorizando']);

          }else if($solicitudPorNivel[0]['tpernivel']['pern_nomnivel'] == 4){

          }

        }

        $clientes = TSolicliente::where('scl_sci_id', $id)->get();

        foreach ($clientes as $key => $cliente) {
          $cliente->clientesZonas()->delete();
          $cliente->clientesReferencias()->delete();
          $cliente->delete();
        }

        $solicitudToCreate = TSolicitudctlinv::find($id);

        foreach ($data['personas'] as $key => $value) {
          $objeto = $solicitudToCreate->clientes()->create($value);
          if($data['sci_tipopersona'] == 1){
            $zona = [];
            $zona['scl_scz_id'] = $objeto['scl_id'];
            if(isset($value['clientes_zonas']['scz_zon_id'])){
              $zona['scz_zon_id'] = $value['clientes_zonas']['scz_zon_id'];
            }else{
              $zona['scz_zon_id'] = $value['scz_zon_id'];
            }
            $zona['scz_porcentaje'] = 100;
            $zona['scz_porcentaje_real'] = null;
            $zona['scz_vdescuento'] = null;
            $zona['scz_vesperado'] = null;
            $zona['scz_estado'] = 1;
            $objetoZonas = $objeto->clientesZonas()->create($zona);
          }

          foreach ($value['solicitud']['referencias'] as $clave => $dato) {
            $objeto->clientesReferencias()->create($dato);
          }
        }

        $response = compact('solicitudToCreate','routeSuccess');
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $userLogged = Auth::user();

      $actualizoEstadoSolicitud =  TSolicitudctlinv::where('sci_id', $id)->update(['sci_soe_id' => 3]);
      $solcitudesPorNivelParaAnular = TSolipernivel::where('sni_sci_id', $id)->update(['sni_estado' => 3]);

      // Genero el historico de correcion
      $historico = new TSolhistorico;
      $historico->soh_sci_id = $id;
      $historico->soh_soe_id = 3;
      $historico->soh_idTercero_envia = $userLogged->idTerceroUsuario;
      $historico->soh_idTercero_recibe = $userLogged->idTerceroUsuario;
      $historico->soh_observacion =  "SOLICITUD ANULADA";
      $historico->soh_fechaenvio = Carbon::now();
      $historico->soh_estadoenvio = 1;
      $historico->save();

      $solicitud = TSolicitudctlinv::find($id);

      return response()->json($solicitud);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function misSolicitudes()
    {
        //
        $ruta = 'Control de Inversion // Mis solicitudes';
        $titulo = 'Mis solicitudes - Obsequios y muestras';
        return view('layouts.controlinversion.solicitud.misSolicitudes', compact('ruta','titulo'));
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getInfoMisolicitudes()
    {
        //esto debe filtrar por usuario campo sci_usuario y sci_tipo 3,7 idTerceroUsuario
        $userLogged = Auth::user();

        $solicitudes = TSolicitudctlinv::with('clientes.clientesReferencias.LineaProducto.LineasProducto', 'clientes.clientesReferencias.referencia' ,'clientes.clientesZonas', 'estado', 'tipoSalida', 'tipoPersona', 'cargara', 'facturara.tercero','cargaralinea.LineasProducto', 'historico', 'historico.estado', 'historico.perNivelEnvia', 'historico.perNivelRecibe')->where('sci_usuario',$userLogged->idTerceroUsuario)->orderBy('sci_id', 'desc')->get();

        $solicitudes->map(function($solicitud){
            $id = $solicitud->sci_id;

            if($solicitud->sci_soe_id == 2){
              $solicitud->rutaCorrecion = route('solicitud.correcion', ['id' => $id]);
            }
            $solicitud->rutaEdit = route('solicitud.edit', ['id' => $id]);
            return $solicitud;
        });

        $response = compact('solicitudes');
        return response()->json($response);
    }


    public function guardarSolicitud($data){

      $solicitudToCreate = TSolicitudctlinv::create($data);

      foreach ($data['personas'] as $key => $value) {
        $objeto = $solicitudToCreate->clientes()->create($value);
        if($data['sci_tipopersona'] == 1){
          $zona = [];
          $zona['scl_scz_id'] = $objeto['scl_id'];
          $zona['scz_zon_id'] = $value['scz_zon_id'];
          $zona['scz_porcentaje'] = 100;
          $zona['scz_porcentaje_real'] = null;
          $zona['scz_vdescuento'] = null;
          $zona['scz_vesperado'] = null;
          $zona['scz_estado'] = 1;
          $objetoZonas = $objeto->clientesZonas()->create($zona);
        }

        foreach ($value['solicitud']['referencias'] as $clave => $dato) {
          $objeto->clientesReferencias()->create($dato);
        }
      }

      $solicitudPorNivel = new TSolipernivel;
      $solicitudPorNivel->sni_usrnivel = $data['userNivel'][0]['id'];
      $solicitudPorNivel->sni_cedula = $data['userNivel'][0]['pern_cedula'];
      $solicitudPorNivel->sni_sci_id = $solicitudToCreate->sci_id;
      $solicitudPorNivel->sni_estado = 0;
      if($data['userNivel'][0]['pern_nomnivel'] == 3){
        $solicitudPorNivel->sni_orden = 1;
      }else{
        $solicitudPorNivel->sni_orden = null;
      }
      $solicitudPorNivel->save();

      $registroHistorico = new TSolhistorico;
      $registroHistorico->soh_sci_id = $solicitudToCreate->sci_id;
      $registroHistorico->soh_soe_id = $solicitudToCreate->sci_soe_id;
      $registroHistorico->soh_idTercero_envia = $data['userNivel'][0]['pern_cedula'];
      $registroHistorico->soh_idTercero_recibe = $data['userNivel'][0]['pern_cedula'];
      $registroHistorico->soh_observacion = "CREACION DE SOLICITUD";
      $registroHistorico->soh_fechaenvio = Carbon::now();
      $registroHistorico->soh_estadoenvio = 1;
      $registroHistorico->save();

      return $solicitudToCreate;

    }



}
