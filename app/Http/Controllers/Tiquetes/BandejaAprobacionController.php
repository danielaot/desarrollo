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
//use App\Models\Tiquetes\TEvaluacion as Evaluacion;

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

      $solicitud = SoliPernivel::with('detallepernivel', 'detallesolicitud')->get();

      /*$solicitudes = Solicitud::with('detalle.ciuOrigen', 'detalle.ciuDestino', 'detalle.aerolinea',
                                     'estados', 'perExterna', 'perCrea', 'pago.tipoPago', 'solipernivel')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->get();*/

      $response =  compact('solicitud','usulogin');

      return response()->json($response);
    }

    static function store(Request $request,$idSolicitud = null,$isCreating = false,$isCreatingAndSend = false,$isExt = false){
      //return ("--->");
      return $request;
      $dataSolicitud = $request->all();
      $dataSolicitud['idSolicitud'] = $idSolicitud;
      $beneficiario = $dataSolicitud['nombre'];
      $error = [];

      if($beneficiario['pen_idtipoper'] == 1 || $beneficiario['pen_idtipoper'] == 2){

          if($beneficiario['pen_idtipoper'] == 1){
return ("--->1");
              if($isCreating == true){
                  self::grabarRutaAprobacion($beneficiario,$dataSolicitud,$isCreating,$isCreatingAndSend);
              }else{
                  $filtraDteAprobacion = collect($beneficiario['detalle'])
                                        ->filter(function($dte)use($beneficiario,$dataSolicitud){
                                            return (($dte['aprobador']['nivaprobador']['pen_nomnivel'] == $beneficiario['nivel']['niv_padre']) && ($dte['perdepIntCanal'] == $dataSolicitud['canalaprobacion']['can_id']));
                                        })->values();


                  if(count($filtraDteAprobacion) > 0){
                      $ruta = self::grabarRutaAprobacion($filtraDteAprobacion[0],$dataSolicitud,$isCreating,$isCreatingAndSend);
                      $dataSolicitud['primeraruta'] = $ruta;
                  }else{
                      $error = ["message" => "No existe ruta de aprobación para el canal ". $dataSolicitud['canalaprobacion']['can_descripcion']];
                      return $error;
                  }
              }
          }elseif ($beneficiario['pen_idtipoper'] == 2) {
          //  return ("--->2");
            if($isCreating == true){
                self::grabarRutaAprobacion($beneficiario,$dataSolicitud,$isCreating,$isCreatingAndSend);
            }else{
              return response()->json($beneficiario);
                $filtraDteAprobacion = collect($beneficiario['detalle'])
                                      ->filter(function($dte)use($beneficiario,$dataSolicitud){
                                          return (($dte['aprobador']['nivaprobador']['pen_nomnivel'] == $beneficiario['nivel']['niv_padre']) && ($dte['perdepIntTerritorio'] == $dataSolicitud['territorioaprobacion']['id']) && ($dte['perdepIntCanal'] == $dataSolicitud['canalaprobacion']['can_id']));
                                      })->values();

              //  return $filtraDteAprobacion;
                if(count($filtraDteAprobacion) > 0){
                    $ruta = self::grabarRutaAprobacion($filtraDteAprobacion[0],$dataSolicitud,$isCreating,$isCreatingAndSend);
                    $dataSolicitud['primeraruta'] = $ruta;
                }else{
                    $error = ["message" => "No existe ruta de aprobación para el canal ". $dataSolicitud['canalaprobacion']['can_descripcion']];
                    return $error;
                }
            }
          }
        }
        if($isExt){
            return $dataSolicitud;
        }else{
            return response()->json($dataSolicitud);
        }
    }

    public static function grabarRutaAprobacion($beneficiario,$dataSolicitud,$isCreating = false,$isCreatingAndSend = false){

        if($isCreating == true){

            /*$solicitudPerNivel = new TSolipernivel;
            $solicitudPerNivel->sni_idpernivel = $beneficiario['id'];
            $solicitudPerNivel->sni_cedula = $beneficiario['pen_cedula'];
            $solicitudPerNivel->sni_idsolicitud = $dataSolicitud['idSolicitud'];
            $solicitudPerNivel->sni_estado = 0;
            $solicitudPerNivel->sni_orden = 0;
            $solicitudPerNivel->save();
            self::grabarHistorico($beneficiario,null,$dataSolicitud,$isCreating);*/

        }else{
            $usuarioEntrega = $beneficiario['ejecutivo'];
            $usuarioRecibe = $beneficiario['aprobador'];

            if($isCreatingAndSend == true){
                self::grabarRutaAprobacion($usuarioEntrega,$dataSolicitud,true,false);
                //$dataSolicitud['estadoSolicitud'] = 4;
             }

            $solicitudPerNivel = new SoliPernivel;
            $solicitudPerNivel->sni_idpernivel = $usuarioRecibe['nivaprobador']['id'];
            $solicitudPerNivel->sni_cedula = $usuarioRecibe['nivaprobador']['pen_cedula'];
            $solicitudPerNivel->sni_idsolicitud = $dataSolicitud['idSolicitud'];
            $solicitudPerNivel->sni_estado = 0;
            $solicitudPerNivel->sni_orden = 0;
            $solicitudPerNivel->save();

            $actualizaEstadoRuta = SoliPernivel::where(['sni_idpernivel' => $usuarioEntrega['pernivejecutivo']['id'], 'sni_idsolicitud' => $dataSolicitud['idSolicitud']])
                                                 ->update(['sni_estado' => 1]);

            self::grabarHistorico($usuarioEntrega,$usuarioRecibe,$dataSolicitud,$isCreating);
        }
    }

    public static function grabarHistorico($usuarioEntrega,$usuarioRecibe = null,$dataSolicitud,$isCreating = false){

    if($isCreating == true){

        $observacion = trim($dataSolicitud['motivo']) == "" ? "Solicitud en elaboración" : $dataSolicitud['motivo'];

        $historico = new Evaluacion;
        $historico->evaIntSolicitud = $dataSolicitud['idSolicitud'];
        $historico->evaTxtCedtercero = $usuarioEntrega['pernivejecutivo']['pen_cedula'];
        $historico->evaTxtnombreter = $usuarioEntrega['pernivejecutivo']['pen_nombre'];
        $historico->evatxtObservacione = $observacion;
        $historico->evaIntFecha = strtotime(Carbon::now()->addMinute(1)->toDateTimeString());;
        $historico->evaTxtCedterAnt = $usuarioEntrega['pernivejecutivo']['pen_cedula'];
        $historico->evaTxtNomterAnt = $usuarioEntrega['pernivejecutivo']['pen_nombre'];
        $historico->evaIntTipoSolicitudAnt = 4;
        $historico->evaEstado = 'S';
        $historico->save();

    }else{

        $observacion = $dataSolicitud['motivo'];

        $historico = new Evaluacion;
        $historico->evaIntSolicitud = $dataSolicitud['idSolicitud'];
        $historico->evaTxtCedtercero = $usuarioRecibe['nivaprobador']['pen_cedula'];
        $historico->evaTxtnombreter = $usuarioRecibe['nivaprobador']['pen_nombre'];
        $historico->evatxtObservacione = $observacion;
        $historico->evaIntFecha = strtotime(Carbon::now()->addMinute(1)->toDateTimeString());;
        $historico->evaTxtCedterAnt = $usuarioEntrega['pernivejecutivo']['pen_cedula'];
        $historico->evaTxtNomterAnt = $usuarioEntrega['pernivejecutivo']['pen_nombre'];
        $historico->evaIntTipoSolicitudAnt = 4;
        $historico->evaEstado = 'S';
        $historico->save();

    }
  }

}
