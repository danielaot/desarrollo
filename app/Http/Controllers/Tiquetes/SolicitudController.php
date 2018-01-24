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
      $persona = PersonaDepende::with('infopersona', 'aprueba')->get();
      $ciudad = Ciudad::all();


      $response =  compact('persona', 'ciudad');

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
      $solicitudes = Solicitud::with('detalle', 'perExterna')
                                ->where('solTxtCedterceroCrea', '1144094290')
                                ->whereNotIn('solIntEstado', [1])
                                ->get();
      return response()->json($solicitudes);
    }

    public function CrearSolicitud(Request $request)
    {

        if ($request->tipo == 1) {
          $solicitud = new Solicitud;
          $solicitud->solIntFecha = '1507738632';
          $solicitud->solTxtCedterceroCrea = '1144094290';
          $solicitud->solIntPersona = $request['nombre']['infopersona']['perIntId'];
          $solicitud->solTxtCedtercero = $request['nombre']['infopersona']['perTxtCedtercero'];
          $solicitud->solTxtNomtercero = $request['nombre']['infopersona']['perTxtNomtercero'];
          $solicitud->solTxtEmail = $request['nombre']['infopersona']['perTxtEmailter'];
          $solicitud->solIntFNacimiento = $request['nombre']['infopersona']['perTxtFechaNac'];
          $solicitud->solTxtObservacion = $request->motivo;
          $solicitud->solIntEstado = 1;
          $solicitud->solIntTiposolicitud = $request->tviaje;
          $solicitud->solTxtTipoNU = $request->tipo;
          $solicitud->solTxtSolAnterior = "0";
          $solicitud->solTxtMotivotarde = "";
          $solicitud->solTxtPerExterna = $request->tviajero;
          $solicitud->solTxtNumTelefono = $request->numtelefono;
          $solicitud->solIntIdCanal = 0;
          $solicitud->solIntIdZona = 0;
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
          $solicitud->solIntFecha = '1507738632';
          $solicitud->solTxtCedterceroCrea = '1144094290';
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
          $solicitud->solIntIdCanal = 0;
          $solicitud->solIntIdZona = 0;
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
