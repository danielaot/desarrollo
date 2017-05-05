<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Genericas\TDirNacional as DirNacional;
use App\Models\Pricat\TProceso as Proceso;
use App\Models\Pricat\TArea as Area;
use App\Models\Pricat\TActividad as Actividad;

class ProcesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Procesos';
        $titulo = 'Administración de Procesos y Actividades';

        return view('layouts.pricat.catalogos.indexProcesos', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $procesos = Proceso::with('actividades.areas')->get();
        $areas = Area::with('responsables.usuarios')->get();
        $actividades = Actividad::with('predecesoras')->get();
        $usuarios = DirNacional::all();

        $response = compact('procesos', 'areas', 'actividades', 'usuarios');

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
          'pro_nombre' => 'required',
          'pro_descripcion' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json($validator->errors());
        }

        $proceso = Proceso::create($request->all());

        return response()->json($proceso);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeActividad(Request $request)
    {
        $validationRules = [
          'act_titulo' => 'required',
          'act_descripcion' => 'required',
          'act_ar_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json($validator->errors());
        }

        $actividad = Actividad::create($request->all());

        if($request->pre_act_pre_id != '')
          $actividad->predecesoras()->create(['pre_act_id' => $actividad->id, 'pre_act_pre_id' => $request->pre_act_pre_id]);

        return response()->json($actividad);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Proceso::where('id', $id)->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyActividad($id)
    {
        return Actividad::where('id', $id)->delete();
    }
}
