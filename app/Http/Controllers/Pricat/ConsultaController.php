<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;

use App\Models\Pricat\TProyecto as Proyecto;
use App\Models\Pricat\TProceso as Proceso;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as TItemDetalle;

class ConsultaController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Proyectos';
        $titulo = 'Consulta de Referencias';

        return view('layouts.pricat.actividades.indexConsulta', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $proyectos = Proyecto::with('procesos')->get();
        
        $referencias =

        $response = compact('proyectos', 'procesos');

        return response()->json($response);
    }
}
