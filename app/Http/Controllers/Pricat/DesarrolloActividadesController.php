<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

use App\Models\Pricat\TProyecto as Proyecto;
use App\Models\Pricat\TProceso as Proceso;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;

class DesarrolloActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Desarrollo de Actividades';

        $desarrollos = Desarrollo::with('proyectos', 'actividades')
                                 ->where('dac_estado', "En Proceso")
                                 ->whereHas('actividades.areas.responsables', function ($query) {
                                            $query->where('res_usuario', Auth::user()->idTerceroUsuario);
                                        })
                                 ->get()
                                 ->groupBy('dac_proy_id');

        return view('layouts.pricat.actividades.indexDesarrollo', compact('ruta', 'titulo','desarrollos'));
    }
}
