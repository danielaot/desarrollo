<?php

namespace App\Http\Controllers\controlinversion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TLineas;
use App\Models\Genericas\TCanal;
use App\Models\controlinversion\TNiveles;
use App\Models\controlinversion\TSolestado;
use App\Models\controlinversion\TPerniveles;
use App\Models\controlinversion\TCanalpernivel;
use App\Models\controlinversion\TSolipernivel;
use App\Models\controlinversion\TSolhistorico;
use App\Models\controlinversion\TSolicitudctlinv;
use App\Models\BESA\VendedorZona; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Mail;
use App\Mail\notificacionEstadoSolicitud;


class autorizacionController extends Controller
{


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $ruta = "Control inversiones // Aprobacion de Solicitudes";
      $titulo = "Aprobar Solicitud";
      return view('layouts.controlinversion.solicitud.autorizacionSolicitud', compact('ruta', 'titulo'));
  }

  public static function solicitudesAprobacionGetInfo()
  {

    $userLogged = Auth::user();
    $userExistPernivel = TPerniveles::where('pern_cedula', $userLogged->idTerceroUsuario)->get();
    $estados = TSolestado::whereIn('soe_id', ['5','2','3'])->get();

    if(count($userExistPernivel) > 0){

      if($userExistPernivel[0]->pern_nomnivel == 2 || $userExistPernivel[0]->pern_nomnivel == 3){

        if($userExistPernivel[0]->pern_nomnivel == 2){
           $todasSolicitudes = TSolipernivel::where('sni_estado', 0)->get();
           $solicitudesPorAceptar = TSolipernivel::getSolicitudesPorAceptar(false,null,$userExistPernivel[0]->id);
            // necesito validar si en el arreglo todas la solicitudes existe alguna en estado cero con el mismo numero de solicitud y con sni_orden menor
        }elseif($userExistPernivel[0]->pern_nomnivel == 3){

          $todasSolicitudes = TSolipernivel::where('sni_estado', 0)->whereNotNull('sni_orden')->get();
          $solicitudesPorAceptar = TSolipernivel::getSolicitudesPorAceptar(false,null,$userExistPernivel[0]->id);
          // necesito validar si en el arreglo todas la solicitudes existe alguna en estado cero con el mismo numero de solicitud y con sni_orden menor

          $array = [];
          foreach ($solicitudesPorAceptar as $key => $solicitud) {

            $filterTodas = [];
            foreach ($todasSolicitudes as $key => $tsoli) {
              if($tsoli->sni_sci_id == $solicitud->sni_sci_id && $tsoli->sni_orden < $solicitud->sni_orden){
                array_push($filterTodas, $tsoli);
              };
            }

            if(count($filterTodas) > 0){
              //array_push($array, null);
            }elseif(count($filterTodas) == 0){
              array_push($array, $solicitud);
            }
          }

          $solicitudesPorAceptar = collect($array)->filter()->all();

        }

      }else{
          return response()->json(['Message' => 'El usuario no tiene privilegios suficientes para aprobar solicitudes'],203);
      }

    }else{
      return response()->json(['Message' => 'El usuario no tiene privilegios suficientes para aprobar solicitudes'],203);
    }

    $response = compact('userLogged','userExistPernivel', 'solicitudesPorAceptar', 'estados');


    return response()->json($response);


  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public static function store(Request $request, $idSolicitud = null, $isCreating = null)
  {
    $data = $request->all();
    //return response()->json($data);

    if($idSolicitud != null){

      //$data = $dataValidacion;
      $nivelesAutorizaNew = TSolipernivel::getSolicitudesPorAceptar(true, $idSolicitud, $data['userNivel'][0]['id']);
      $data = $nivelesAutorizaNew[0]['solicitud'];
      $data['estadoSolicitud'] = $nivelesAutorizaNew[0]['solicitud']['estado'];
      $data['observacionEnvio'] = "";
      $data['usuarioLogeado'] = Auth::user();

      if($isCreating != null){

        if($isCreating == true){
          $data['isCreating'] = true;
        }else{
          $data['isCreating'] = false;
        }

      }

      //echo "<pre>";print_r($data['usuarioLogeado']);exit;

    }
      $userExistPernivel = TPerniveles::with('tperjefe')->where('pern_cedula', $data['usuarioLogeado']['idTerceroUsuario'])->get();
    // Valida el estado de la solicitud, si es 3 se debe anular en la tabla y retornar exito
    if($data['estadoSolicitud']['soe_id'] == 3){

      $actualizoEstadoSolicitud =  TSolicitudctlinv::where('sci_id', $data['sci_id'])->update(['sci_soe_id' => 3]);
      $solcitudesPorNivelParaAnular = TSolipernivel::where('sni_sci_id', $data['sci_id'])->update(['sni_estado' => 3]);

      // Genero el historico de correcion
      $historico = new TSolhistorico;
      $historico->soh_sci_id = $data['sci_id'];
      $historico->soh_soe_id = 3;
      $historico->soh_idTercero_envia = $data['usuarioLogeado']['idTerceroUsuario'];
      $historico->soh_idTercero_recibe = $data['usuarioLogeado']['idTerceroUsuario'];

      if(isset($data['observacionEnvio'])){
        if ($data['observacionEnvio'] == "") {
          $data['observacionEnvio'] = "SIN OBSERVACION";
        }
      }else{
        $data['observacionEnvio'] = "SIN OBSERVACION";
      }

      $historico->soh_observacion =  $data['observacionEnvio'];
      $historico->soh_fechaenvio = Carbon::now();
      $historico->soh_estadoenvio = 1;
      $historico->save();

      return 'exito';

    }elseif($data['estadoSolicitud']['soe_id'] == 2){
      // Valida el estado de la solicitud, si es 3 se debe ponerla en estado correcciones y retornar exito
      $actualizoEstadoSolicitud =  TSolicitudctlinv::where('sci_id', $data['sci_id'])->update(['sci_soe_id' => 2]);
      $objetoGuardar = TSolipernivel::where('sni_sci_id', $data['sci_id'])->orderBy('id', 'asc')->first();
      $borrapermisos = TSolipernivel::where('sni_sci_id', $data['sci_id'])->orderBy('id', 'asc')->delete();

      $solipornivel = new TSolipernivel;
      $solipornivel->sni_usrnivel = $objetoGuardar->sni_usrnivel;
      $solipornivel->sni_cedula = $objetoGuardar->sni_cedula;
      $solipornivel->sni_sci_id = $objetoGuardar->sni_sci_id;
      $solipornivel->sni_estado = 0;
      $solipornivel->sni_orden= $objetoGuardar->sni_orden;
      $solipornivel->save();

      // Genero el historico de correcion
      $historico = new TSolhistorico;
      $historico->soh_sci_id = $data['sci_id'];
      $historico->soh_soe_id = 2;
      $historico->soh_idTercero_envia = $data['usuarioLogeado']['idTerceroUsuario'];
      $historico->soh_idTercero_recibe = $solipornivel->sni_cedula;

      if(isset($data['observacionEnvio'])){
        if ($data['observacionEnvio'] == "") {
          $data['observacionEnvio'] = "SIN OBSERVACION";
        }
      }else{
        $data['observacionEnvio'] = "SIN OBSERVACION";
      }

      $historico->soh_observacion =  $data['observacionEnvio'];
      $historico->soh_fechaenvio = Carbon::now();
      $historico->soh_estadoenvio = 1;
      $historico->save();

      $dataSolicitud = TSolhistorico::with('perNivelEnvia', 'perNivelRecibe', 'estado', 'solicitud', 'solicitud.clientes', 'solicitud.clientes.clientesReferencias', 'solicitud.clientes.clientesReferencias.referencia', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio.LineasProducto', 'solicitud.cargaralinea', 'solicitud.cargaralinea.LineasProducto')->where('soh_id',$historico->soh_id)->first();
      $correo = ['omolaya@bellezaexpress.com'];
      Mail::to($correo)->send(new notificacionEstadoSolicitud($dataSolicitud));

      if(Mail::failures()){
          return response()->json(Mail::failures());
      }

      return 'exito';
    }

    //echo "<pre>--";print_r($data['sci_soe_id'] == 0 && $userExistPernivel[0]['pern_nomnivel'] == 2);exit;

    if($data['sci_soe_id'] == 0 && $userExistPernivel[0]['pern_nomnivel'] == 2){

      $actualizoEstadoSolicitud =  TSolicitudctlinv::where('sci_id', $data['sci_id'])->update(['sci_soe_id' => 1]);

    }


    // Obtengo el canal
    $canal = $data['sci_can_id'];
    $clientes = $data['clientes'];

    // Obtengo las lineas de todas las referencias asociadas a cada cliente

    if($idSolicitud == null){
        $lineasSolicitud = collect($data['clientes'])->pluck('clientes_referencias')->flatten(1)->groupBy('referencia.ite_cod_linea')->keys()->all();
    }else{
        $lineasSolicitud = collect($data['clientes'])->pluck('clientesReferencias')->flatten(1)->groupBy('referencia.ite_cod_linea')->keys()->all();
    }

    if(trim($data['sci_cargarlinea']) != ""){
      $lineaGeneral = (int)trim($data['sci_cargarlinea']);
      array_push($lineasSolicitud,$lineaGeneral);
    }


    // Obtengo de los niveles de aprobacion las personas que aprueban para esa linea en ese canal
    $quienesSon = TCanalpernivel::where('cap_idcanal', trim($canal))->whereIn('cap_idlinea',$lineasSolicitud)->get();

    // Si no hay nadie que apruebe retorno error
    if (count($quienesSon) == 0) {

      return "errorNoExisteNivelTres";

    }elseif($userExistPernivel[0]['pern_nomnivel'] == 3){

        if(!isset($data['isCreating'])){
          $data['isCreating'] = false;
        }

        if($data['isCreating'] == false){

          $user = TSolipernivel::where([['sni_cedula', $data['usuarioLogeado']['idTerceroUsuario']], ['sni_sci_id', $data['sci_id']]])->update(['sni_estado' => 1]);
          $existenMasPasos = TSolipernivel::where([['sni_sci_id', $data['sci_id']], ['sni_estado', 0]])->whereNotNull('sni_orden')->get();

          // Genero el historico de aprobacion de nivel 3 a nivel 4
          $historico = new TSolhistorico;
          $historico->soh_sci_id = $data['sci_id'];
          $historico->soh_idTercero_envia = $data['usuarioLogeado']['idTerceroUsuario'];

          if(isset($data['observacionEnvio'])){
            if ($data['observacionEnvio'] == "") {
              $data['observacionEnvio'] = "SIN OBSERVACION";
            }
          }else{
            $data['observacionEnvio'] = "SIN OBSERVACION";
          }

          $historico->soh_observacion =  $data['observacionEnvio'];
          $historico->soh_fechaenvio = Carbon::now();
          $historico->soh_estadoenvio = 1;


          if(count($existenMasPasos) == 0){

            $solicitudUpdateNew = TSolicitudctlinv::where('sci_id', $data['sci_id'])->update(['sci_soe_id' => 5]);
            $grabo = TSolipernivel::create(['sni_usrnivel' => $userExistPernivel[0]['pern_jefe'], 'sni_cedula' => $userExistPernivel[0]['tperjefe']['pern_cedula'], 'sni_sci_id' => $data['sci_id'], 'sni_estado' => 0, 'sni_orden' => null]);
            $historico->soh_idTercero_recibe = $userExistPernivel[0]['tperjefe']['pern_cedula'];
            $historico->soh_soe_id = 5;

          }else{
            $historico->soh_soe_id = $data['sci_soe_id'];
            $historico->soh_idTercero_recibe = $existenMasPasos[0]['sni_cedula'];
          }

          $historico->save();


                $dataSolicitud = TSolhistorico::with('perNivelEnvia', 'perNivelRecibe', 'estado', 'solicitud', 'solicitud.clientes', 'solicitud.clientes.clientesReferencias', 'solicitud.clientes.clientesReferencias.referencia', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio.LineasProducto', 'solicitud.cargaralinea', 'solicitud.cargaralinea.LineasProducto')->where('soh_id',$historico->soh_id)->first();

          $correo = ['omolaya@bellezaexpress.com'];
          Mail::to($correo)->send(new notificacionEstadoSolicitud($dataSolicitud));

          if(Mail::failures()){
              return response()->json(Mail::failures());
          }


        }else{

          $userSoliPernivel = TSolipernivel::where([['sni_cedula', $data['usuarioLogeado']['idTerceroUsuario']], ['sni_sci_id', $data['sci_id']]])->get();
          //Se crean los demas nivel 3 pendientes por aprobar
          $quienesSonAgrupados = $quienesSon->groupBy('cap_idpernivel')->keys()->all();
          $personaNiveles = TPerniveles::whereIn('id', $quienesSonAgrupados)->get();
          $contador = $userSoliPernivel[0]['sni_orden'] + 1;

          // Actualizo estado anterior
          $update = TSolipernivel::where([['sni_cedula', $data['usuarioLogeado']['idTerceroUsuario']], ['sni_sci_id', $data['sci_id']]])->update(['sni_estado' => 1]);

          // Creo nuevos pasos de aprobacion para personas de nivel 3

          $personasAgregadas = [];

          foreach ($personaNiveles as $key => $value) {
            if($value['pern_cedula'] != $data['usuarioLogeado']['idTerceroUsuario']){
              array_push($personasAgregadas, $value);
              $grabo = TSolipernivel::create(['sni_usrnivel' => $value['id'], 'sni_cedula' => $value['pern_cedula'], 'sni_sci_id' => $data['sci_id'], 'sni_estado' => 0, 'sni_orden' => $contador]);
              $contador++;
            }
          }

          // Genero el historico de aprobacion de nivel 3 a nivel 3
          $historico = new TSolhistorico;
          $historico->soh_sci_id = $data['sci_id'];
          $historico->soh_soe_id = $data['sci_soe_id'];
          $historico->soh_idTercero_envia = $data['usuarioLogeado']['idTerceroUsuario'];
          $historico->soh_idTercero_recibe = $personasAgregadas[0]['pern_cedula'];

          if($data['sci_observaciones'] != null && trim($data['sci_observaciones']) != ""){
            $data['observacionEnvio'] = $data['sci_observaciones'];
          }else{
            $data['observacionEnvio'] = "ENVIO DE SOLICITUD";
          }

          $historico->soh_observacion =  $data['observacionEnvio'];
          $historico->soh_fechaenvio = Carbon::now();
          $historico->soh_estadoenvio = 1;
          $historico->save();

          $dataSolicitud = TSolhistorico::with('perNivelEnvia', 'perNivelRecibe', 'estado', 'solicitud', 'solicitud.clientes', 'solicitud.clientes.clientesReferencias', 'solicitud.clientes.clientesReferencias.referencia', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio.LineasProducto', 'solicitud.cargaralinea', 'solicitud.cargaralinea.LineasProducto')->where('soh_id',$historico->soh_id)->first();

          $correo = ['omolaya@bellezaexpress.com'];
          Mail::to($correo)->send(new notificacionEstadoSolicitud($dataSolicitud));

          if(Mail::failures()){
              return response()->json(Mail::failures());
          }

        }

    }else{

      if(!isset($data['isCreating'])){
        $data['isCreating'] = false;
      }
      //Validar si el usuario logeado es de nivel 2
      // Si no, creo la ruta de aprobacion
      $quienesSonAgrupados = $quienesSon->groupBy('cap_idpernivel')->keys()->all();
      $personaNiveles = TPerniveles::whereIn('id', $quienesSonAgrupados)->get();
      $contador = 1;

      // Actualizo estado anterior
      $update = TSolipernivel::where([['sni_cedula', $data['usuarioLogeado']['idTerceroUsuario']], ['sni_sci_id', $data['sci_id']]])->update(['sni_estado' => 1]);

      // Creo nuevos pasos
      foreach ($personaNiveles as $key => $value) {
        $grabo = TSolipernivel::create(['sni_usrnivel' => $value['id'], 'sni_cedula' => $value['pern_cedula'], 'sni_sci_id' => $data['sci_id'], 'sni_estado' => 0, 'sni_orden' => $contador]);
        $contador++;
      }

      // Genero el historico de aprobacion de nivel 2 a nivel 3
      $historico = new TSolhistorico;
      $historico->soh_sci_id = $data['sci_id'];
      $historico->soh_soe_id = $data['sci_soe_id'];
      $historico->soh_idTercero_envia = $data['usuarioLogeado']['idTerceroUsuario'];
      $historico->soh_idTercero_recibe = $personaNiveles[0]['pern_cedula'];

      if($data['isCreating'] == false){

        if(isset($data['observacionEnvio'])){

          if ($data['observacionEnvio'] == "") {
            $data['observacionEnvio'] = "SIN OBSERVACION";
          }

        }else{

          $data['observacionEnvio'] = "SIN OBSERVACION";

        }

      }else{

        if($data['sci_observaciones'] != null && trim($data['sci_observaciones']) != ""){
          $data['observacionEnvio'] = $data['sci_observaciones'];
        }else{
          $data['observacionEnvio'] = "ENVIO DE SOLICITUD";
        }

      }

      $historico->soh_observacion =  $data['observacionEnvio'];
      $historico->soh_fechaenvio = Carbon::now();
      $historico->soh_estadoenvio = 1;
      $historico->save();

      $dataSolicitud = TSolhistorico::with('perNivelEnvia', 'perNivelRecibe', 'estado', 'solicitud', 'solicitud.clientes', 'solicitud.clientes.clientesReferencias', 'solicitud.clientes.clientesReferencias.referencia', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio', 'solicitud.clientes.clientesReferencias.referencia.LineaItemCriterio.LineasProducto', 'solicitud.cargaralinea', 'solicitud.cargaralinea.LineasProducto')->where('soh_id',$historico->soh_id)->first();

      $correo = ['omolaya@bellezaexpress.com'];
      Mail::to($correo)->send(new notificacionEstadoSolicitud($dataSolicitud));

      if(Mail::failures()){
          return response()->json(Mail::failures());
      }

    }

    $response = compact('data', 'canal', 'lineasSolicitud', 'clientes', 'personaNiveles');
    return $response;
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
