<?php

namespace App\Http\Controllers\Tiquetes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tiquetes\TPersona as Personas;
use App\Models\Tiquetes\TPersonaDepende as PersonaDepende;
use App\Models\Tiquetes\TCiudad as Ciudad;
use App\Models\Tiquetes\TCiudade as CiudadPais;
use App\Models\Tiquetes\TPaises as Pais;
use App\Models\Tiquetes\TSolicitud as Solicitud;
use App\Models\Tiquetes\TPersonaexterna as PersonaExterna;
use App\Models\Tiquetes\TDetallesolictud as DetalleSolicitud;
use App\Models\Tiquetes\TSolipernivel as SoliPernivel;
use App\Models\Tiquetes\TEvaluacion as Evaluacion;
use App\Models\Tiquetes\TPernivele as PerNivel;
use App\Models\Tiquetes\TEstados as Estados;
use App\Models\Tiquetes\TCompradoresgerencium as CompradoresGerencia;

use Auth;
use DB;
use Carbon\Carbon;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

class BandejaAprobacionController extends Controller
{

    public function index()
    {
        $ruta = 'Tiquetes y Hotel // Revisión Solicitud';
        $titulo = 'Revisión Solicitud';
        return view('layouts.tiquetes.nivelesAutorizacion.bandejaAprobacion', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {

      $usuario = Auth::user();
      $usulogin = PerNivel::where('pen_cedula', $usuario['idTerceroUsuario'])->get();

      $solicitud = SoliPernivel::with('detallesolicitud',
                                      'detallesolicitud.canal',
                                      'detallesolicitud.grupoaprobacion',
                                      'detallesolicitud.territorioaprobacion',
                                      'detallesolicitud.tipoGerencia',
                                      'detallepernivel', 'detallepernivel.nivel',
                                      'detallepernivel.nivel.nivelpadre',
                                      'detallepernivel.detalle.aprobador.nivaprobador',
                                      'detallepernivel.detalle.ejecutivo.pernivejecutivo.nivel',
                                      'detallepernivel.detalle.territorio',
                                      'detallepernivel.detalle.canal',
                                      'detallepernivel.detalle.grupo',
                                      'detallesolicitud.estados',
                                      'detallesolicitud.detalle.ciuOrigen',
                                      'detallesolicitud.detalle.ciuDestino',
                                      'detallesolicitud.detalle.aerolinea',
                                      'detallesolicitud.detalle.hotel',
                                      'detallesolicitud.detalle.ciuIntOrigen',
                                      'detallesolicitud.detalle.ciuIntDestino',
                                      'detallesolicitud.perCrea')
                                      ->where(['sni_cedula' => $usuario['idTerceroUsuario'], 'sni_estado' => 0])->get();

      $estadosAprobacion = Estados::whereIn('estIntEstado', [12,6,2])->get();
      /*$solicitudes = Solicitud::with('detalle.ciuOrigen', 'detalle.ciuDestino', 'detalle.aerolinea',
                                     'estados', 'perExterna', 'perCrea', 'pago.tipoPago', 'solipernivel')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->get();*/

      $response =  compact('solicitud','usulogin', 'estadosAprobacion');

      return response()->json($response);
    }

    static function store(Request $request,$idSolicitud = null,$isCreating = false,$isCreatingAndSend = false,$isExt = false){

      $dataSolicitud = $request->all();
      $error = ["isSuccess" => false, "message" => ""];
      $filtraDteAprobacion = [];
      $dataToApprobation = [];

      if($isExt){

          if ($dataSolicitud['nombre']['pen_idtipoper'] == 1) {
              $dataSolicitud['idSolicitud'] = $idSolicitud;
              $beneficiario = $dataSolicitud['nombre'];

          }elseif ($dataSolicitud['nombre']['pen_idtipoper'] == 2) {
              $dataSolicitud['idSolicitud'] = $idSolicitud;
              $beneficiario = $dataSolicitud['nombre']['detalle'][0];
              $beneficiario['nivel']['niv_gerencial'] = $dataSolicitud['nombre']['nivel']['niv_gerencial'];
              $beneficiario['nivel']['nivelpadre']['niv_gerencial'] = $dataSolicitud['nombre']['nivel']['nivelpadre']['id'];
              $beneficiario['pen_idtipoper'] = $dataSolicitud['nombre']['pen_idtipoper'];
              $beneficiario['detalle'] = $dataSolicitud['nombre']['detalle'];
              $beneficiario['nivel']['niv_padre'] = $dataSolicitud['nombre']['nivel']['niv_padre'];
              $beneficiario['pen_cedula'] = $dataSolicitud['nombre']['pen_cedula'];
              $beneficiario['pen_nombre'] = $dataSolicitud['nombre']['pen_nombre'];

          }elseif ($dataSolicitud['nombre']['pen_idtipoper'] == 3 || $dataSolicitud['nombre']['pen_idtipoper'] == 4) {
              $dataSolicitud['idSolicitud'] = $idSolicitud;
              $beneficiario = $dataSolicitud['nombre'];
          }elseif ($dataSolicitud['nombre']['pen_idtipoper'] == 5) {
              $dataSolicitud['idSolicitud'] = $idSolicitud;
              $beneficiario = $dataSolicitud['nombre'];
              $dataSolicitud['tipoPersona'] = $dataSolicitud['nombre']['pen_idtipoper'];
              $beneficiario['pen_idtipoper'] = $dataSolicitud['nombre']['pen_idtipoper'];
//return $beneficiario['pen_idtipoper'];
          }
          //$dataSolicitud['idSolicitud'] = $idSolicitud;
          //  $beneficiario = $dataSolicitud['nombre'];

      }
      else{
          $dataSolicitud = $request->all();
          $dataSolicitud['idSolicitud'] = $request['sni_idsolicitud'];
          $dataSolicitud['solTxtGerencia'] = $request['detallesolicitud']['solTxtGerencia'];
          $dataSolicitud['canalaprobacion'] = $request['detallesolicitud']['canal'];
          $dataSolicitud['grupoaprobacion'] = $request['detallesolicitud']['grupoaprobacion'];
          $beneficiario = $dataSolicitud['detallepernivel'];
          $beneficiario['ejecutivo']['tipo_persona']['id'] = $dataSolicitud['detallepernivel']['pen_idtipoper'];
          $beneficiario['ejecutivo'] = $dataSolicitud['detallepernivel']['detalle'][0]['ejecutivo'];
          $beneficiario['datosGerencia']['cod_gerencia'] = $dataSolicitud['detallepernivel']['pen_idgerencia'];
          $beneficiario['aprobador']['nivaprobador'] = $dataSolicitud['detallepernivel']['detalle'][0]['aprobador']['nivaprobador'];
          $dataSolicitud['territorioaprobacion'] = $request['detallesolicitud']['territorioaprobacion'];
      }

      if($isCreating == true){
           self::grabarRutaAprobacion($beneficiario,$dataSolicitud,$isCreating,$isCreatingAndSend);
       }else{

        $validarRutaAprobacion = self::validarRutaAprobacion($beneficiario,$dataSolicitud);
         if($validarRutaAprobacion['hasRoute'] == true){
            $filtraDteAprobacion = $validarRutaAprobacion['response'];
          }

          if($beneficiario['nivel']['niv_gerencial'] != 1){

              if($beneficiario['nivel']['nivelpadre']['niv_gerencial'] != 1){

                $response = self::grabarRutaAprobacion($filtraDteAprobacion,$dataSolicitud,$isCreating,$isCreatingAndSend);
                //  $response = self::grabarRutaAprobacion($filtraDteAprobacion,$beneficiario,$dataSolicitud,$isCreating,$isCreatingAndSend);
                $dataSolicitud['respuestaAutorizacion'] = $response;
                  /*if(count($filtraDteAprobacion) > 0){
                  }else{
                      $error['message'] = "No existe una ruta de aprobación para el canal de la solicitud";
                      $dataSolicitud['respuestaAutorizacion'] = $error;
                  }*/
              }else{
                $response = self::grabarRutaAprobacion($beneficiario,$dataSolicitud,$isCreating,$isCreatingAndSend);
                $dataSolicitud['respuestaAutorizacion'] = $response;
                /*if(count($filtraDteAprobacion) > 0){
                  //  $response = self::grabarRutaAprobacion($filtraDteAprobacion,$beneficiario,$dataSolicitud,$isCreating,$isCreatingAndSend);
                }else{
                      $error['message'] = "No existe una ruta de aprobación que coincida con la gerencia de la solicitud";
                      $dataSolicitud['respuestaAutorizacion'] = $error;
                  }*/
              }
          }else{

              $compradorGerencia = CompradoresGerencia::with('datocomprador')->where('comgerIntIdGerencia', $dataSolicitud['detallepernivel']['detalle'][0]['ejecutivo']['perIntTipogerencia'])->get();

              $observacion = trim($dataSolicitud['motivo']) == "" ? "Solicitud en elaboración" : $dataSolicitud['motivo'];
              $historico = new Evaluacion;
              $historico->evaIntSolicitud = $dataSolicitud['idSolicitud'];
              $historico->evaTxtCedtercero = $compradorGerencia['comgerTxtIdTercero'];
              $historico->evaTxtnombreter = $compradorGerencia['datocomprador']['nombreEstablecimientoTercero'];
              $historico->evatxtObservacione = $observacion;
              $historico->evaIntFecha = strtotime(Carbon::now()->addMinute(1)->toDateTimeString());;
              $historico->evaTxtCedterAnt = $dataSolicitud['detallepernivel']['detalle'][0]['ejecutivo']['perTxtCedtercero'];
              $historico->evaTxtNomterAnt = $dataSolicitud['detallepernivel']['detalle'][0]['ejecutivo']['perTxtNomtercero'];
              $historico->evaIntTipoSolicitudAnt = 12;
              $historico->evaEstado = 'S';
              $historico->save();

              $response = ['isSuccess' => true, 'message' => 'Se ha creado la ruta correctamente.'];
              $dataSolicitud['respuestaAutorizacion'] = $response;

            }
        }
        if($isExt){
            return $dataSolicitud;
        }else{
            return response()->json($dataSolicitud);
        }
    }

    public static function grabarRutaAprobacion($beneficiario,$dataSolicitud,$isCreating = false,$isCreatingAndSend = false){

      $response = [];
      if($isCreating == true){

          $solicitudPerNivel = new SoliPernivel;
          $solicitudPerNivel->sni_idpernivel = $beneficiario['id'];
          $solicitudPerNivel->sni_cedula = $beneficiario['pen_cedula'];
          $solicitudPerNivel->sni_idsolicitud = $dataSolicitud['idSolicitud'];
          $solicitudPerNivel->sni_estado = 0;
          $solicitudPerNivel->sni_orden = 0;
          $solicitudPerNivel->save();
          self::grabarHistorico($beneficiario,null,$dataSolicitud,$isCreating);

        }else{

                $usuarioEntrega = $beneficiario['ejecutivo']['pernivejecutivo'];
                $usuarioRecibe = $beneficiario['aprobador']['nivaprobador'];

            /*  if ($dataSolicitud['tipoPersona'] == "5") {
                $usuarioEntrega = $dataSolicitud['nombre']['detalle'][0]['ejecutivo']['pernivejecutivo'];
                $usuarioRecibe = $dataSolicitud['nombre']['detalle'][0]['aprobador']['nivaprobador'];
              }else {
                $usuarioEntrega = $beneficiario['ejecutivo']['pernivejecutivo'];
                $usuarioRecibe = $beneficiario['aprobador']['nivaprobador'];
              }*/

              if($isCreatingAndSend == true){

                  self::grabarRutaAprobacion($usuarioEntrega,$dataSolicitud,true,false);
                  if($usuarioEntrega['nivel']['niv_gerencial'] == 1){
                    $dataSolicitud['estadoSolicitud'] = 5;
                    $dataSolicitud['observacion'] = 'Aprueba Servicios Administrativos';
                  }else{

                      $dataSolicitud['estadoSolicitud'] = 4;
                      $dataSolicitud['motivo'] = 'Pendiente por aprobación';
                  }

                  $solicitudPerNivel = new SoliPernivel;
                  $solicitudPerNivel->sni_idpernivel = $usuarioRecibe['id'];
                  $solicitudPerNivel->sni_cedula = $usuarioRecibe['pen_cedula'];
                  $solicitudPerNivel->sni_idsolicitud = $dataSolicitud['idSolicitud'];
                  $solicitudPerNivel->sni_estado = 0;
                  $solicitudPerNivel->sni_orden = 0;
                  $solicitudPerNivel->save();

                  $actualizaEstadoRuta = SoliPernivel::where(['sni_idpernivel' => $usuarioEntrega['id'], 'sni_idsolicitud' => $dataSolicitud['idSolicitud']])
                                                       ->update(['sni_estado' => 1]);

                  $actualizaSolicitud= Solicitud::where('solIntSolId', $dataSolicitud['idSolicitud'])->update(['solIntEstado' => $dataSolicitud['estadoSolicitud']]);
               }else{

                if($dataSolicitud['estado']['estIntEstado'] == 12){//Aprueba Solicitud
                 //if($dataSolicitud['estadoSolicitud'] == 12){//Aprueba Solicitud

                    $estadoSolicitud = 4;
                    if($usuarioEntrega['nivel']['niv_gerencial'] == 1){
                        $obs = isset($dataSolicitud['motivo'])? $dataSolicitud['motivo'] : 'Aprueba Servicios Administrativos';
                        $estadoSolicitud = 5;
                        $dataSolicitud['motivo'] = $obs;
                    }else{
                        $obs = isset($dataSolicitud['motivo']) ? $dataSolicitud['motivo'] : 'Pendiente por aprobación';
                        $estadoSolicitud = 4;
                        $dataSolicitud['motivo'] = $obs;
                    }

                    $dataSolicitud['estadoSolicitud'] = $estadoSolicitud;
                    $solicitudPerNivel = new Solipernivel;
                    $solicitudPerNivel->sni_idpernivel = $usuarioRecibe['id'];
                    $solicitudPerNivel->sni_cedula = $usuarioRecibe['pen_cedula'];
                    $solicitudPerNivel->sni_idsolicitud = $dataSolicitud['idSolicitud'];
                    $solicitudPerNivel->sni_estado = 0;
                    $solicitudPerNivel->sni_orden = 0;
                    $solicitudPerNivel->save();

                    $actualizaEstadoRuta = SoliPernivel::where(['sni_idpernivel' => $usuarioEntrega['id'], 'sni_idsolicitud' => $dataSolicitud['idSolicitud']])
                    ->update(['sni_estado' => 1]);

                    $actualizaSolicitud= Solicitud::where('solIntSolId', $dataSolicitud['idSolicitud'])->update(['solIntEstado' => $estadoSolicitud]);

               }elseif($dataSolicitud['estadoSolicitud'] == 6){//Rechaza Solicitud
                 return ("--->");
                  /*  $usuarioCreador = $dataSolicitud['pernivelbeneficiario'];
                    $dataSolicitud['observacion'] = isset($dataSolicitud['observacion'])?$dataSolicitud['observacion']:'Solicitud Rechazada';
                    $estadoSolicitud = $dataSolicitud['estadoSolicitud'];

                    self::grabarHistorico($usuarioEntrega,$usuarioCreador,$dataSolicitud,$isCreating);

                    $actualizaEstadoRuta = TSolipernivel::where(['sni_idpernivel' => $usuarioEntrega['id'], 'sni_idsolicitud' => $dataSolicitud['sol_int_id']])->update(['sni_estado' => 1]);

                    $actualizaSolicitud= TSolicitud::where('sol_int_id', $dataSolicitud['sol_int_id'])->update(['sol_int_idestado' => $estadoSolicitud]);

                    $response = ['isSuccess' => true, 'message' => 'Se ha rechazado la solicitud correctamente.'];
                    return $response;*/

                }elseif($dataSolicitud['estadoSolicitud'] == 2){//Envia a Correciones la Solicitud
                  return ("----->");
                  /*  $usuarioCreador = $dataSolicitud['tpernivelbeneficiario'];
                    $eliminarRutaActual = TSolipernivel::where('sni_idsolicitud', $dataSolicitud['sol_int_id'])->delete();
                    $estadoSolicitud = $dataSolicitud['estadoSolicitud'];

                    self::grabarRutaAprobacion($usuarioCreador,$dataSolicitud,true,false);

                    $actualizaSolicitud= TSolicitud::where('sol_int_id', $dataSolicitud['sol_int_id'])->update(['sol_int_idestado' => $estadoSolicitud]);

                    self::grabarHistorico($usuarioEntrega,$usuarioCreador,$dataSolicitud,$isCreating,true);
                    $response = ['isSuccess' => true, 'message' => 'Se ha enviado a correciones correctamente la solicitud.'];
                    return $response;*/
                }
            }

            self::grabarHistorico($usuarioEntrega,$usuarioRecibe,$dataSolicitud,$isCreating);

        $response = ['isSuccess' => true, 'message' => 'Se ha creado la ruta de aprobación correctamente'];
        return $response;

      }

    }

    public static function grabarHistorico($usuarioEntrega,$usuarioRecibe = null,$dataSolicitud,$isCreating = false, $forceSave = false){
      $puedePasar = true;

      if($isCreating == true){

        $observacion = trim($dataSolicitud['motivo']) == "" ? "Solicitud en elaboración" : $dataSolicitud['motivo'];
        $historico = new Evaluacion;
        $historico->evaIntSolicitud = $dataSolicitud['idSolicitud'];
        $historico->evaTxtCedtercero = $usuarioEntrega['pen_cedula'];
        $historico->evaTxtnombreter = $usuarioEntrega['pen_nombre'];
        $historico->evatxtObservacione = $observacion;
        $historico->evaIntFecha = strtotime(Carbon::now()->addMinute(1)->toDateTimeString());;
        $historico->evaTxtCedterAnt = $usuarioEntrega['pen_cedula'];
        $historico->evaTxtNomterAnt = $usuarioEntrega['pen_nombre'];
        $historico->evaIntTipoSolicitudAnt = 4;
        $historico->evaEstado = 'S';
        $historico->save();
      }else{

        $observacion = $dataSolicitud['motivo'];

        $historico = new Evaluacion;
        $historico->evaIntSolicitud = $dataSolicitud['idSolicitud'];
        $historico->evaTxtCedtercero = $usuarioRecibe['pen_cedula'];
        $historico->evaTxtnombreter = $usuarioRecibe['pen_nombre'];
        $historico->evatxtObservacione = $observacion;
        $historico->evaIntFecha = strtotime(Carbon::now()->addMinute(1)->toDateTimeString());;
        $historico->evaTxtCedterAnt = $usuarioEntrega['pen_cedula'];
        $historico->evaTxtNomterAnt = $usuarioEntrega['pen_nombre'];
        $historico->evaIntTipoSolicitudAnt = 4;
        $historico->evaEstado = 'S';
        $historico->save();

    }
  }

  public static function validarRutaAprobacion($beneficiario,$dataSolicitud){
    $filtraDteAprobacion = [];
    $response = ['hasRoute' => false, 'response' => []];

    if($beneficiario['nivel']['niv_gerencial'] != 1){
      if($beneficiario['nivel']['nivelpadre']['niv_gerencial'] != 1){
        if($beneficiario['pen_idtipoper'] == 1 || $beneficiario['pen_idtipoper'] == 2){

             if($beneficiario['pen_idtipoper'] == 1){
                  $filtraDteAprobacion = collect($beneficiario['detalle'])
                  ->filter(function($dte)use($beneficiario,$dataSolicitud){
                  return (($dte['aprobador']['nivaprobador']['pen_nomnivel'] == $beneficiario['nivel']['niv_padre']) && ($dte['perdepIntCanal'] == $dataSolicitud['canalaprobacion']['can_id']));
                  //return (($dte['tpernivelaprobador']['pen_nomnivel'] == $beneficiario['nivel']['niv_padre']) && ($dte['pnd_canal'] == $dataSolicitud['canalaprobacion']['can_id']));
                  })->values();
              }else{
                  $filtraDteAprobacion = collect($beneficiario['detalle'])
                  ->filter(function($dte)use($beneficiario,$dataSolicitud){
                  return (($dte['aprobador']['nivaprobador']['pen_nomnivel'] == $beneficiario['nivel']['niv_padre']) && ($dte['perdepIntCanal'] == $dataSolicitud['canalaprobacion']['can_id']) && ($dte['perdepIntTerritorio'] == $dataSolicitud['territorioaprobacion']['id']));
                  })->values();
              }

              if(count($filtraDteAprobacion) > 0){
                        $filtraDteAprobacion = $filtraDteAprobacion[0];
              }
      }elseif ($beneficiario['pen_idtipoper'] == 3 || $beneficiario['pen_idtipoper'] == 4) {

          if($beneficiario['pen_nomnivel'] == 1){
               $consultaMercadeo = PersonaDepende::with('perejecutivo')->where(['perdepPerIntIdtipoper' => $beneficiario['pen_idtipoper'], 'perdepIntNivel' => $beneficiario['nivel']['niv_padre'], 'perdepIntGrupo' => $dataSolicitud['grupoaprobacion']['id'], 'perdepIntCanal' => $dataSolicitud['canalaprobacion']['can_id']])->first();
           }else{
               $consultaMercadeo = PersonaDepende::with('perejecutivo')->where(['perdepPerIntIdtipoper' => $beneficiario['pen_idtipoper'], 'perdepIntNivel' => $beneficiario['nivel']['niv_padre'], 'perdepIntGrupo' => $dataSolicitud['grupoaprobacion']['id']])->first();
               }

            if(count($consultaMercadeo) > 0){
                $filtraDteAprobacion['ejecutivo'] = $beneficiario['detalle'][0]['ejecutivo'];
                $filtraDteAprobacion['ejecutivo']['tipo_persona']['id'] = $beneficiario['pen_idtipoper'];
                $filtraDteAprobacion['aprobador']['nivaprobador'] = $consultaMercadeo['perejecutivo'];
             }
      }elseif($beneficiario['pen_idtipoper'] == 5){
            $filtraDteAprobacion = collect($beneficiario['detalle'])
            ->filter(function($dte)use($beneficiario,$dataSolicitud){
                return (($dte['aprobador']['nivaprobador']['pen_nomnivel'] == $beneficiario['nivel']['niv_padre']) && ($dte['perdepPerIntIdtipoper'] == $beneficiario['pen_idtipoper']));
             })->values();

             if(count($filtraDteAprobacion) > 0){
                 $filtraDteAprobacion = $filtraDteAprobacion[0];
             }
      }
    }else{
        if(isset($dataSolicitud['detallesolicitud']['solTxtGerencia'])){
            $gerencia = $dataSolicitud['detallesolicitud']['solTxtGerencia'];
        }else{
            $gerencia = trim($beneficiario['datosGerencia']['cod_gerencia']);
        }

          $nivelGerencial = PersonaDepende::with('perejecutivo')->where(['perdepIntNivel' => $beneficiario['nivel']['nivelpadre']['id'], 'perdepPerIntGerencia' => $gerencia])->first();

          if(count($nivelGerencial)){
                    $filtraDteAprobacion['tpernivelejecutivo'] = $beneficiario;
                    $filtraDteAprobacion['tpernivelaprobador'] = $nivelGerencial['tpernivelejecutivo'];
          }
    }
  }else{

      $cambiarEstadoSoli = Solicitud::where('solIntSolId', $dataSolicitud['idSolicitud'])->update(['solIntEstado' => 12]);
      // if(count($aprobadorTesoreria) > 0){
      //     $filtraDllAprobacion['tpernivelejecutivo'] = $beneficiario;
      //     $filtraDllAprobacion['tpernivelaprobador'] = $aprobadorTesoreria;
      // }
    }

    if(count($filtraDteAprobacion) > 0){
        $response['hasRoute'] = true;
        $response['response'] = $filtraDteAprobacion;
        return $response;
    }else{
        return $response;
    }

  }

}
