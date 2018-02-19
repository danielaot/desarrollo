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

use Auth;
use DB;

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
                                     'estados', 'perExterna', 'perCrea', 'pago.tipoPago')
                                ->where('solTxtCedterceroCrea', '1144094290')
                                ->get();

                                /*with('detalle.ciuOrigen', 'detalle.ciuDestino', 'detalle.aerolinea',
                                     'estados', 'perExterna', 'perCrea', 'pago.tipoPago')
                                ->where('solTxtCedterceroCrea', $usuario['idTerceroUsuario'])
                                ->get();*/
    //  $rutaPdf = route('generarPdf');

      $response =  compact('solicitudes','usuario', 'rutaPdf');

      return response()->json($response);
    }

    public function generarPdf(Request $request){
      $data = $request->all();
      dd($data);
    }

    public function enviarSolicitud(Request $request)
    {
        $updateEstado = Solicitud::where('solIntSolId', $request->solIntSolId)
                                  ->update(['solIntEstado' => 4]);

        return response()->json($updateEstado);
    }

    public function anularSolicitud(Request $request)
    {
        $updateEstado = Solicitud::where('solIntSolId', $request->solIntSolId)
                                  ->update(['solIntEstado' => 3]);

        return response()->json($updateEstado);
    }
}
