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
use App\Models\Tiquetes\TPernivele as PerNivel;
use App\Models\Tiquetes\TPersonaexterna as PersonaExterna;
use App\Models\Tiquetes\TDetallesolictud as DetalleSolicitud;
use App\Models\Tiquetes\TSolipernivel as SoliPernivel;
use App\Models\Tiquetes\TEvaluacion as Evaluacion;
use App\Models\Genericas\TCanal;
//use App\Http\Controllers\Controller;

use App\Http\Controllers\Tiquetes\BandejaAprobacionController as AutorizacionCtrl;

use Carbon\Carbon;
use Auth;
use DB;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

class SolicitudController extends Controller
{

    public function index()
    {
        $ruta = 'Tiquetes y Hotel // Crear Solicitud';
        $titulo = 'Crear Solicitud';
        return view('layouts.tiquetes.solicitud.crearSolicitud', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
      $usuario = Auth::user();
      //$persona = PerNivel::with('nivel', 'detpersona.detallenivelpersona.aprobador')->get();
      $canales = TCanal::with('canalesperniveles')->whereIn('can_id',['20','AL','DR','SI'])->get();

      $persona = PerNivel::with('nivel.nivelpadre','tipoPersona', 'detpersona.detallenivelpersona.aprobador',
                                'detalle.grupo', 'detalle.canal', 'detalle.territorio', 'detalle.aprobador.nivaprobador.nivel',
                                'detalle.ejecutivo.pernivejecutivo.nivel')->get();
      $ciudad = Ciudad::all();

      $response =  compact('persona', 'ciudad', 'usuario', 'canales');

      return response()->json($response);
    }

    public function paisesInfo()
    {
      $paises = Pais::with('ciudades')->get();
      $response =  compact('paises');

      return response()->json($response);
    }

    public function modifica()
    {
      $usuario = Auth::user();
      $solicitudes = Solicitud::with('detalle', 'perExterna')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->whereNotIn('solIntEstado', [1])
                                ->get();
      return response()->json($solicitudes);
    }

    public function store(Request $request, $isCreating = false)
    {
        $usuario = Auth::user();
        $usulogin = PerNivel::where('pen_cedula', $usuario['idTerceroUsuario'])->get();
        $isCreating = $isCreating == "false" ? false: true;
      //  return response()->json($usulogin);
        if ($request->tipo == 1) {
          $solicitud = new Solicitud;
          $solicitud->solIntFecha = '1507738632';
          $solicitud->solTxtCedterceroCrea = '1144094290';
          //$solicitud->solTxtCedterceroCrea = $usulogin[0]['pen_cedula'];
          $solicitud->solIntPersona = $request['nombre']['detpersona']['perIntId'];
          $solicitud->solTxtCedtercero = $request['nombre']['pen_cedula'];
          $solicitud->solTxtNomtercero = $request['nombre']['pen_nombre'];
          $solicitud->solTxtEmail = $request['nombre']['detpersona']['perTxtEmailter'];
          $solicitud->solIntFNacimiento = $request['nombre']['detpersona']['perTxtFechaNac'];
          $solicitud->solTxtObservacion = $request->motivo;
          $solicitud->solIntEstado = 1;
          $solicitud->solIntTiposolicitud = $request->tviaje;
          $solicitud->solTxtTipoNU = $request->tipo;
          $solicitud->solTxtSolAnterior = "0";
          $solicitud->solTxtMotivotarde = "";
          $solicitud->solTxtPerExterna = $request->tviajero;
          $solicitud->solTxtNumTelefono = $request->numtelefono;
          $solicitud->solIntIdCanal = $request['canalaprobacion']['can_id'];
          $solicitud->solIntIdZona = $request['territorioaprobacion']['id'];
          $solicitud->solIntIdGrupo = $request['grupoaprobacion']['id'];
          $solicitud->save();

          if ($request->tviajero == 2) {

            $solicitudExterno = new PersonaExterna;
            $solicitudExterno->pereIntSolId = $solicitud->solIntSolId;
            $solicitudExterno->pereTxtCedula = $request->ccexterno;
            $solicitudExterno->pereTxtFNacimiento = Carbon::parse($request['fnacimientoext'])->format('Y-m-d');
            $solicitudExterno->pereTxtNumCelular = $request->numcelexter;
            $solicitudExterno->pereTxtNombComple = $request->nomexterno;
            $solicitudExterno->pereTxtEmail = $request->corexterno;
            $solicitudExterno->save();

            // $solipernivel = new SoliPernivel;
            // $solipernivel->sni_idpernivel = $request['nombre']['pen_nomnivel'];
            // $solipernivel->sni_cedula = $request['nombre']['pen_cedula'];
            // $solipernivel->sni_idsolicitud = $solicitud->solIntSolId;
            // $solipernivel->sni_estado = 0;
            // $solipernivel->sni_orden = 1;
            // $solipernivel->save();
            //
            // $cedaprueba = $request['aprobador']['aprobador']['perTxtCedtercero'];
            // $nomaprueba = $request['aprobador']['aprobador']['perTxtNomtercero'];
            //
            // $evaluacion = new Evaluacion;
            // $evaluacion->evaIntSolicitud = $solicitud->solIntSolId;
            // $evaluacion->evaTxtCedtercero = $cedaprueba;
            // $evaluacion->evaTxtnombreter = $nomaprueba;
            // $evaluacion->evatxtObservacione = $request->motivo;
            // $evaluacion->evaIntFecha = '1516054234';
            // $evaluacion->evaTxtCedterAnt = $request['nombre']['pen_cedula'];
            // $evaluacion->evaTxtNomterAnt = $request['nombre']['pen_nombre'];
            // $evaluacion->evaIntTipoSolicitudAnt = 4;
            // $evaluacion->evaEstado = 'S';
            // $evaluacion->save();
          }

          if ($request->tviaje == 1) {

            foreach ($request->detalleNac as $key => $value) {
              $detSolicitud = new DetalleSolicitud;
              $detSolicitud->dtaIntOCiu = $value['idorigen'];
              $detSolicitud->dtaIntDCiu = $value['iddestino'];
              $detSolicitud->dtaIntFechaVuelo = strtotime($value['fviaje']);
              $detSolicitud->dtaIntIdAerolinea = 0;
              $detSolicitud->dtaIntHoravuelo = 0;
              $detSolicitud->dtaTxtResvuelo = "";
              $detSolicitud->dtaIntCostoVuelo = 0;
              $detSolicitud->dtaTxtFechaCompra = 0;
              $detSolicitud->dtaTxtHotel = $value['hotel'];
              $detSolicitud->dtaIntSolicitud = $solicitud->solIntSolId;
              $detSolicitud->dtaIntCostoAdm = 0;
              $detSolicitud->dtaIntCostoIva = 0;
              $detSolicitud->save();
            }

          }elseif ($request->tviaje == 2) {

            foreach ($request->detalleInt as $key => $value) {
              $detSolicitud = new DetalleSolicitud;
              $detSolicitud->dtaIntOCiu = 0;
              $detSolicitud->dtaTxtOCiu = $value['ciuorigen'];
              $detSolicitud->dtaIntDCiu = 0;
              $detSolicitud->dtaTxtDCiudad = $value['ciudestino'];
              $detSolicitud->dtaIntFechaVuelo = strtotime($value['fviaje']);
              $detSolicitud->dtaIntIdAerolinea = 0;
              $detSolicitud->dtaIntHoravuelo = 0;
              $detSolicitud->dtaTxtResvuelo = "";
              $detSolicitud->dtaIntCostoVuelo = 0;
              $detSolicitud->dtaTxtFechaCompra = 0;
              $detSolicitud->dtaTxtHotel = $value['hotel'];
              $detSolicitud->dtaIntSolicitud = $solicitud->solIntSolId;
              $detSolicitud->dtaIntCostoAdm = 0;
              $detSolicitud->dtaIntCostoIva = 0;
              $detSolicitud->save();
            }
          }
        }

        if ($request->tipo == 2) {
          $solicitud = new Solicitud;
          $solicitud->solIntFecha = '1507738632';
          $solicitud->solTxtCedterceroCrea = '1144094290';
          //$solicitud->solTxtCedterceroCrea = $usulogin[0]['pen_cedula'];
          $solicitud->solIntPersona = $request->perIntId;
          $solicitud->solTxtCedtercero = $request->perTxtCedtercero;
          $solicitud->solTxtNomtercero = $request->nombre;
          $solicitud->solTxtEmail = $request->perTxtEmailter;
          $solicitud->solIntFNacimiento = $request->perTxtFechaNac;
          $solicitud->solTxtObservacion = $request->motivo;
          $solicitud->solIntEstado = 1;
          $solicitud->solIntTiposolicitud = $request->tviaje;
          $solicitud->solTxtTipoNU = $request->tipo;
          $solicitud->solTxtSolAnterior = $request->solAnterior;
          $solicitud->solTxtMotivotarde = "";
          $solicitud->solTxtPerExterna = $request->tviajero;
          $solicitud->solTxtNumTelefono = $request->numtelefono;
          $solicitud->solIntIdCanal = $request['canalaprobacion']['can_id'];
          $solicitud->solIntIdZona = $request['territorioaprobacion']['id'];
          $solicitud->solIntIdGrupo = $request['grupoaprobacion']['id'];
          $solicitud->save();

          if ($request->tviajero == 2) {

            $solicitudExterno = new PersonaExterna;
            $solicitudExterno->pereIntSolId = $solicitud->solIntSolId;
            $solicitudExterno->pereTxtCedula = $request->ccexterno;
            $solicitudExterno->pereTxtFNacimiento = Carbon::parse($request['fnacimientoext'])->format('Y-m-d');
            $solicitudExterno->pereTxtNumCelular = $request->numcelexter;
            $solicitudExterno->pereTxtNombComple = $request->nomexterno;
            $solicitudExterno->pereTxtEmail = $request->corexterno;
            $solicitudExterno->save();
          }

          if ($request->tviaje == 1) {

            foreach ($request->detalleNac as $key => $value) {
              $detSolicitud = new DetalleSolicitud;
              $detSolicitud->dtaIntOCiu = $value['idorigen'];
              $detSolicitud->dtaIntDCiu = $value['iddestino'];
              $detSolicitud->dtaIntFechaVuelo = strtotime($value['fviaje']);
              $detSolicitud->dtaIntIdAerolinea = 0;
              $detSolicitud->dtaIntHoravuelo = 0;
              $detSolicitud->dtaTxtResvuelo = "";
              $detSolicitud->dtaIntCostoVuelo = 0;
              $detSolicitud->dtaTxtFechaCompra = 0;
              $detSolicitud->dtaTxtHotel = $value['hotel'];
              $detSolicitud->dtaIntSolicitud = $solicitud->solIntSolId;
              $detSolicitud->dtaIntCostoAdm = 0;
              $detSolicitud->dtaIntCostoIva = 0;
              $detSolicitud->save();
            }

          }elseif ($request->tviaje == 2) {

            foreach ($request->detalleInt as $key => $value) {
              $detSolicitud = new DetalleSolicitud;
              $detSolicitud->dtaIntOCiu = 0;
              $detSolicitud->dtaTxtOCiu = $value['ciuorigen'];
              $detSolicitud->dtaIntDCiu = 0;
              $detSolicitud->dtaTxtDCiudad = $value['ciudestino'];
              $detSolicitud->dtaIntFechaVuelo = strtotime($value['fviaje']);
              $detSolicitud->dtaIntIdAerolinea = 0;
              $detSolicitud->dtaIntHoravuelo = 0;
              $detSolicitud->dtaTxtResvuelo = "";
              $detSolicitud->dtaIntCostoVuelo = 0;
              $detSolicitud->dtaTxtFechaCompra = 0;
              $detSolicitud->dtaTxtHotel = $value['hotel'];
              $detSolicitud->dtaIntSolicitud = $solicitud->solIntSolId;
              $detSolicitud->dtaIntCostoAdm = 0;
              $detSolicitud->dtaIntCostoIva = 0;
              $detSolicitud->save();
            }
          }
        }

        $data = $request->all();

        if($isCreating == true){
            $rutaAprobacion = AutorizacionCtrl::store($request,$solicitud->solIntSolId,true,false,true);
        }else{
            $rutaAprobacion = AutorizacionCtrl::store($request,$solicitud->solIntSolId,false,true,true);
            //return $rutaAprobacion;
        }
        $response = compact('solicitud', 'detSolicitud', 'data', 'rutaAprobacion');

        return response()->json($response);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
