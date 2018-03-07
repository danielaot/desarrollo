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
      $canales = TCanal::with('canalperniveles')->whereIn('can_id',['20','AL','DR','SI'])->get();

      $persona = PerNivel::with('nivel.nivelpadre','tipoPersona', 'detpersona.detallenivelpersona.aprobador',
                                'detalle.grupo', 'detalle.canal', 'detalle.territorio', 'detalle.aprobador.nivaprobador.nivel',
                                'detalle.ejecutivo.pernivejecutivo.nivel')->get();

      $ciudad = Ciudad::all();
      $fechavalidacion = Carbon::now()->addDays(12);
      $fechahoy = Carbon::now();

      $response =  compact('persona', 'ciudad', 'usuario', 'canales', 'fechahoy', 'fechavalidacion');

      return response()->json($response);
    }

    public function paisesInfo()
    {
      $paises = Pais::with('ciudades')->where('Estado', 1)->get();
      $response =  compact('paises');

      return response()->json($response);
    }

    public function modifica()
    {
      $usuario = Auth::user();
      $solicitudes = Solicitud::with('detalle', 'perExterna', 'perAutoriza.aprueba',
                                     'detalle.ciuIntOrigen.porigen', 'detalle.ciuIntDestino.pdestino',
                                     'detalle.ciuOrigen', 'detalle.ciuDestino', 'detalle.hotel')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->whereNotIn('solIntEstado', [1])
                                ->get();
      return response()->json($solicitudes);
    }

    public function store(Request $request, $isCreating = false)
    {

        $rutaMisSolicitudes = route('misSolicitudesTiquetes');
        $respuestaCreacion = array('isSuccess' => true, 'message' => '', 'rutaMisSolicitudes' => $rutaMisSolicitudes);

        $usuario = Auth::user();
        $fecha = Carbon::now();
        $usulogin = PerNivel::where('pen_cedula', $usuario['idTerceroUsuario'])->get();
        $isCreating = $isCreating == "false" ? false: true;

        if ($request->tipo == 1) {
          $solicitud = new Solicitud;
          $solicitud->solIntFecha = strtotime($fecha);
          $solicitud->solTxtCedterceroCrea = $usuario['idTerceroUsuario'];
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
          $solicitud->solTxtMotivotarde = $request['motivoViaje'];
          $solicitud->solTxtPerExterna = $request->tviajero;
          $solicitud->solTxtNumTelefono = $request->numtelefono;
          $solicitud->solIntIdCanal = $request['canalaprobacion']['can_id'];
          $solicitud->solIntIdZona = $request['territorioaprobacion']['id'];
          $solicitud->solIntIdGrupo = $request['grupoaprobacion']['id'];
          $solicitud->solTxtGerencia = $request['nombre']['detpersona']['perIntTipogerencia'];
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

        if ($request->tipo == 2) {
          $solicitud = new Solicitud;
          $solicitud->solIntFecha = strtotime($fecha);
          $solicitud->solTxtCedterceroCrea = $usuario['idTerceroUsuario'];
          $solicitud->solIntPersona = $request['nombre']['detpersona']['perIntId'];
          $solicitud->solTxtCedtercero = $request['nombre']['pen_cedula'];
          $solicitud->solTxtNomtercero = $request['nombre']['pen_nombre'];
          $solicitud->solTxtEmail = $request['nombre']['detpersona']['perTxtEmailter'];
          $solicitud->solIntFNacimiento = $request['nombre']['detpersona']['perTxtFechaNac'];
          $solicitud->solTxtObservacion = $request->motivo;
          $solicitud->solIntEstado = 1;
          $solicitud->solIntTiposolicitud = $request->tviaje;
          $solicitud->solTxtTipoNU = $request->tipo;
          $solicitud->solTxtSolAnterior = $request->solAnterior;
          $solicitud->solTxtMotivotarde = $request['motivoViaje'];
          $solicitud->solTxtPerExterna = $request->tviajero;
          $solicitud->solTxtNumTelefono = $request->numtelefono;
          $solicitud->solIntIdCanal = $request['canalaprobacion']['can_id'];
          $solicitud->solIntIdZona = $request['territorioaprobacion']['id'];
          $solicitud->solIntIdGrupo = $request['grupoaprobacion']['id'];
          $solicitud->solTxtGerencia = $request['nombre']['detpersona']['perIntTipogerencia'];
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
        }
        $response = compact('solicitud', 'detSolicitud', 'data', 'rutaAprobacion', 'respuestaCreacion');

        return response()->json($response);
    }


    public function edit($id)
    {
      $ruta = 'Tiquetes y Hotel // Editar Solicitud';
      $titulo = 'Editar Solicitud';
      $usuario = Auth::user();

      $solicitudes = Solicitud::with('detalle','detalle.ciuOrigen', 'detalle.ciuDestino',
                                     'detalle.hotel','perExterna', 'perAutoriza.aprueba',
                                     'detalle.ciuIntOrigen.porigen', 'detalle.ciuIntDestino.pdestino',
                                     'territorioaprobacion', 'grupoaprobacion', 'canal')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->where('solIntSolId', $id)
                                ->whereIn('solIntEstado', [1,2])
                                ->get();
      $solicitudes = collect($solicitudes)->map(function($sol){
        $sol['pen_cedula'] = $sol['solTxtCedtercero'];
        $sol['pen_nombre'] = $sol['solTxtNomtercero'];
        return $sol;

      });

      return view('layouts.tiquetes.solicitud.crearSolicitud', compact('ruta', 'titulo', 'solicitudes'));
    }

    public function editSolicitud(Request $request, $isCreating = false)
    {
        //return response()->json($request->all());
        $rutaMisSolicitudes = route('misSolicitudesTiquetes');
        $respuestaCreacion = array('isSuccess' => true, 'message' => '', 'rutaMisSolicitudes' => $rutaMisSolicitudes);

        $usuario = Auth::user();
        $fechaEdicion = Carbon::now();
        $isCreating = $isCreating == "false" ? false: true;

        $updateSolicitud = Solicitud::where('solIntSolId', $request->idSolicitud)
                                    ->update(['solIntFecha' => strtotime($fechaEdicion), 'solTxtCedterceroCrea' => $usuario->idTerceroUsuario,
                                      'solIntPersona' => $request['nombre']['detpersona']['perIntId'],
                                      'solTxtCedtercero' => $request['nombre']['detpersona']['perTxtCedtercero'],
                                      'solTxtNomtercero' => $request['nombre']['detpersona']['perTxtNomtercero'],
                                      'solTxtEmail' => $request['nombre']['detpersona']['perTxtEmailter'],
                                      'solIntFNacimiento' => $request['nombre']['detpersona']['perTxtFechaNac'],
                                      'solTxtObservacion' => $request->motivo, 'solIntTiposolicitud' => $request->tviaje,
                                      'solTxtTipoNU' => $request->tipo, 'solTxtPerExterna' => $request->tviajero,
                                      'solTxtNumTelefono' => $request->numtelefono,
                                      'solIntIdCanal' => isset($request['canalaprobacion']['can_id'])?$request['canalaprobacion']['can_id']:null,
                                      'solIntIdZona' => isset($request['territorioaprobacion']['id'])?$request['territorioaprobacion']['id']:null,
                                      'solIntIdGrupo' => isset($request['grupoaprobacion']['id'])?$request['grupoaprobacion']['id']:null,
                                      'solTxtGerencia' => $request['pen_idgerencia']]);

        if ($request['tviajero'] == 2) {
              $updateDetSolicitud = PersonaExterna::where('pereIntSolId', $request->idSolicitud)
                                                  ->update(['pereTxtCedula' => $request['ccexterno'],
                                                  'pereTxtFNacimiento' => Carbon::parse($request['fnacimientoext'])->format('Y-m-d'),
                                                  'pereTxtNumCelular' => $request['numcelexter'],
                                                  'pereTxtNombComple' => $request['nomexterno'],
                                                  'pereTxtEmail' => $request['corexterno']]);
        }

        if ($request->tviaje == '1') {
           foreach ($request['detalleNac'] as $key => $value) {

             $buscaDet = DetalleSolicitud::where('dtaIntSolicitud', $request->idSolicitud)
                                         ->where('dtaIntOCiu', $value['idorigen'])
                                         ->where('dtaIntDCiu', $value['iddestino'])->get();
              if (count($buscaDet) === 0) {
                $updateDetSolicitud = new DetalleSolicitud;
                $updateDetSolicitud->dtaIntOCiu = $value['idorigen'];
                $updateDetSolicitud->dtaIntDCiu = $value['iddestino'];
                $updateDetSolicitud->dtaIntFechaVuelo = strtotime($value['fviaje']);
                $updateDetSolicitud->dtaIntIdAerolinea = 0;
                $updateDetSolicitud->dtaIntHoravuelo = 0;
                $updateDetSolicitud->dtaTxtResvuelo = "";
                $updateDetSolicitud->dtaIntCostoVuelo = 0;
                $updateDetSolicitud->dtaTxtFechaCompra = 0;
                $updateDetSolicitud->dtaTxtHotel = $value['hotel'];
                $updateDetSolicitud->dtaIntSolicitud = $request->idSolicitud;
                $updateDetSolicitud->dtaIntCostoAdm = 0;
                $updateDetSolicitud->dtaIntCostoIva = 0;
                $updateDetSolicitud->save();
              }

           }
         }elseif ($request->tviaje == 2) {

           foreach ($request->detalleInt as $key => $value) {

             $buscaDet = DetalleSolicitud::where('dtaIntSolicitud', $request->idSolicitud)
                                         ->where('dtaTxtOCiu', $value['ciuorigen'])
                                         ->where('dtaTxtDCiudad', $value['ciudestino'])->get();

              if (count($buscaDet) === 0) {
                $updateDetSolicitud = new DetalleSolicitud;
                $updateDetSolicitud->dtaIntOCiu = 0;
                $updateDetSolicitud->dtaTxtOCiu = $value['ciuorigen'];
                $updateDetSolicitud->dtaIntDCiu = 0;
                $updateDetSolicitud->dtaTxtDCiudad = $value['ciudestino'];
                $updateDetSolicitud->dtaIntFechaVuelo = strtotime($value['fviaje']);
                $updateDetSolicitud->dtaIntIdAerolinea = 0;
                $updateDetSolicitud->dtaIntHoravuelo = 0;
                $updateDetSolicitud->dtaTxtResvuelo = "";
                $updateDetSolicitud->dtaIntCostoVuelo = 0;
                $updateDetSolicitud->dtaTxtFechaCompra = 0;
                $updateDetSolicitud->dtaTxtHotel = $value['hotel'];
                $updateDetSolicitud->dtaIntSolicitud = $request->idSolicitud;
                $updateDetSolicitud->dtaIntCostoAdm = 0;
                $updateDetSolicitud->dtaIntCostoIva = 0;
                $updateDetSolicitud->save();
              }
           }
         }

         $data = $request->all();

         if($isCreating == true){

             $rutaAprobacion = AutorizacionCtrl::store($request,$request->idSolicitud,true,false,true);
         }else{

             $rutaAprobacion = AutorizacionCtrl::store($request,$request->idSolicitud,false,true,true);
         }

         $response = compact('updateDetSolicitud', 'data', 'rutaAprobacion', 'respuestaCreacion');

         return response()->json($response);
    }

}
