<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TCondManipulacion as CManipulacion;
use App\Models\Pricat\TTipoEmpaque as TEmpaque;
use App\Models\Pricat\TTipoEmbalaje as TEmbalaje;

class Paso7Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Ingreso de Información de Medidas';

        return view('layouts.pricat.actividades.paso7', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $cmanipulacion = CManipulacion::all();
        $tempaque = TEmpaque::all();
        $tembalaje = TEmbalaje::all();

        $response = compact('cmanipulacion', 'tempaque', 'tembalaje');

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
