<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TNotificacionSanitaria as NotSanitaria;
use App\Models\Genericas\TItemCriterio as ItemCriterio;

class NotificacionSanitariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Notificación Sanitaria';
        $titulo = 'Notificación Sanitaria';

        return view('layouts.pricat.notificacionsanitaria.indexNotificacionesSanitarias', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $notificaciones = NotSanitaria::all();
        $graneles = ItemCriterio::where('ite_num_tipoinventario', 1062)->get();

        $response = compact('notificaciones', 'graneles');

        return response()->json($response);
    }
}
