<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TProyecto as Proyecto;
use App\Models\Pricat\TProceso as Proceso;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;

class ProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Proyectos';
        $titulo = 'Administración de Proyectos';

        return view('layouts.pricat.catalogos.indexProyectos', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $proyectos = Proyecto::with('procesos')->get();
        $procesos = Proceso::all();

        $response = compact('proyectos', 'procesos');

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
          'proy_nombre' => 'required',
          'proy_descripcion' => 'required',
          'proy_proc_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json($validator->errors());
        }

        $proyecto = Proyecto::create($request->all());

        $proceso = Proceso::with('actividades.predecesoras')
                          ->where('id', $request->proy_proc_id)
                          ->first();

        foreach ($proceso->actividades as $actividad){
          $estado = count($actividad->predecesoras) > 0 ? 'Pendiente' : 'En Proceso';

          $desarrollo = new Desarrollo;
          $desarrollo->dac_proy_id = $proyecto->id;
          $desarrollo->dac_act_id = $actividad->id;
          $desarrollo->dac_estado = $estado;
          $desarrollo->save();
        }

        return response()->json($proceso);
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
        $proyecto = Proyecto::find($id);
        $proyecto->proy_nombre = $request->proy_nombre;
        $proyecto->proy_descripcion = $request->proy_descripcion;
        $proyecto->proy_proc_id = $request->proy_proc_id;
        $proyecto->save();

        return response()->json($proyecto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Proyecto::where('id', $id)->delete();
    }
}
