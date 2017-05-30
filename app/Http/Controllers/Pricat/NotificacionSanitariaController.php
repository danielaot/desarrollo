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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
          'nosa_nombre' => 'required',
          'nosa_notificacion' => 'required',
          'nosa_fecha_inicio' => 'required',
          'nosa_fecha_vencimiento' => 'required',
          'documento' => 'required|file'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        if ($request->hasFile('documento')){
          $file = $request->file('documento');
          $fileName = rand(1, 999) . $file->getClientOriginalName();

          $file->storePubliclyAs('/public/pricat/registrosanitario/', $fileName);
        }

        return response()->json($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validationRules = [
          'nosa_nombre' => 'required',
          'nosa_notificacion' => 'required',
          'nosa_fecha_inicio' => 'required',
          'nosa_fecha_vencimiento' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }


        return response()->json($request->all());
    }
}
