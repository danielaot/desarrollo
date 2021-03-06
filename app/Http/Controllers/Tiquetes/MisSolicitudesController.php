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

use App\Http\Controllers\Tiquetes\BandejaAprobacionController as AutorizacionCtrl;

use Auth;
use DB;
use Carbon\Carbon;
use PDF;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

class MisSolicitudesController extends Controller
{

    public function index()
    {
        $ruta = 'Tiquetes y Hotel // Mis Solicitudes';
        $titulo = 'Mis Solicitudes';
        return view('layouts.tiquetes.solicitud.misSolicitudes', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {

      $usuario = Auth::user();
      $solicitudes = Solicitud::with('detalle.ciuOrigen', 'detalle.ciuDestino', 'detalle.aerolinea',
                                     'estados', 'perExterna', 'perCrea', 'pago.tipoPago', 'evaluaciones', 'evaluaciones.estado',
                                     'personaPernivel', 'personaPernivel.nivel.nivelpadre', 'personaPernivel.detalle.grupo', 'personaPernivel.detalle.canal',
                                     'personaPernivel.detalle.aprobador.nivaprobador.nivel', 'personaPernivel.detalle.ejecutivo.pernivejecutivo.nivel',
                                     'personaPernivel.detalle.territorio', 'personaPernivel.detpersona.detallenivelpersona.aprobador', 'personaPernivel.detalle',
                                     'personaPernivel.tipoPersona')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->get();
      /*$solicitudes = Solicitud::with('detalle.ciuOrigen', 'detalle.ciuDestino', 'detalle.aerolinea',
                                     'estados', 'perExterna', 'perCrea', 'pago.tipoPago', 'evaluaciones', 'evaluaciones.estado')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->get();*/

      $solicitudes = collect($solicitudes)->map(function($solicitud){
        $solicitud['urlEdit'] = route('editarSolicitud',['idSolicitud' => $solicitud['solIntSolId']]);
        return $solicitud;
      });
      $rutaPdf = route('imprimirLegalizacionTiquetes');

      $response =  compact('solicitudes','usuario', 'rutaPdf');

      return response()->json($response);
    }

    public function imprimirLegalizacion(Request $request){
      $data = $request->all();
      $solicitudImprimir = Solicitud::where('solIntSolId', $data['objSolicitud'])->with('personaGerencia', 'personaGerencia.gerencia', 'perExterna', 'detalle', 'detalle.ciuOrigen', 'detalle.ciuOrigen.departamento', 'detalle.ciuDestino', 'detalle.ciuDestino.departamento', 'detalle.aerolinea', 'detalle.hotel')->first();
      // dd($solicitudImprimir);
      $fechaSolicitud = Carbon::createFromTimestamp($solicitudImprimir['solIntFecha'])->toDateString();
      $fechaNacimiento = Carbon::createFromTimestamp($solicitudImprimir['solIntFNacimiento'])->toDateString();
      $i = 0;

      foreach ($solicitudImprimir['detalle'] as $fecha) {
        $fecha['contador'] = $i + 1;
        $i = $fecha['contador'];
        if ($fecha['dtaIntHoravuelo'] != 0) {
          $fecha['dtaIntHoravuelo'] = Carbon::createFromTimestamp($fecha['dtaIntHoravuelo'])->toTimeString();
        }else{
          $fecha['dtaIntHoravuelo'] = Carbon::createFromTimestamp($fecha['dtaIntFechaVuelo'])->toTimeString();
        }
        $fecha['dtaIntFechaVuelo'] = Carbon::createFromTimestamp($fecha['dtaIntFechaVuelo'])->toDateString();
      }

      $response = compact('solicitudImprimir', 'fechaSolicitud', 'fechaNacimiento');
      // return view('layouts.tiquetes.solicitud.Reportes.reporteImprimir', $response);
        $pdf = PDF::loadView('layouts.tiquetes.solicitud.Reportes.reporteImprimir', $response);
        return $pdf->download('FormatoTiquetesHotel_GOP-FOR-004_No'. $data['objSolicitud']. '.pdf');

    }

    public function enviarSolicitud(Request $request)
    {
      //return response()->json($request);

        $data = $request->all();
        $rutaAprobacion = AutorizacionCtrl::store($request,false,false,true);

        $response = compact('data', 'rutaAprobacion');

        return response()->json($response);
    }

    public function anularSolicitud(Request $request)
    {
        $updateEstado = Solicitud::where('solIntSolId', $request->solIntSolId)
                                  ->update(['solIntEstado' => 3]);

        return response()->json($updateEstado);
    }
}
