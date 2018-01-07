<?php

namespace App\Http\Controllers\Tiquetes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tiquetes\TPersona as Personas;
use App\Models\Tiquetes\TPersonaDepende as PersonaDepende;
use App\Models\Tiquetes\TCiudad as Ciudad;
use App\Models\Tiquetes\TCiudade as CiudadPais;
use App\Models\Tiquetes\TPaises as Pais;

use DB;

ini_set('memory_limit', '-1');

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
      //$personas = Personas::with('personaxaprobar', 'personaxaprobar.infopersona')->get();

      $persona = PersonaDepende::with('infopersona', 'aprueba')->get();

      $response =  compact('persona');
    //  $response =  compact('personas', 'aprueba', 'paises');

      return response()->json($response);
    }


    public function store(Request $request)
    {
        //
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
