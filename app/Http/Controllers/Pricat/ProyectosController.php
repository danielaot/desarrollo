<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;

use App\Models\Pricat\TProyecto as Proyecto;
use App\Models\Pricat\TProceso as Proceso;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;

class ProyectosController extends Controller
{

    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Proyectos';
        $titulo = 'Administración de Proyectos';

        return view('layouts.pricat.catalogos.indexProyectos', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $proyectosterm = Proyecto::with('procesos')
                                       ->where('proy_estado', 'Terminado')->get();
        $proyectosproc = Proyecto::with('procesos')
                                      ->where('proy_estado', 'En Proceso')->get();

        $proyectosxcert = Proyecto::with('procesos')
                                    ->where('proy_estado', 'Por Certificar')->get();

        $proyectospau = Proyecto::with('procesos')
                                  ->where('proy_estado', 'Pausado')->get();

        $proyectoscan = Proyecto::with('procesos')
                                    ->where('proy_estado', 'Cancelado')->get();

        $procesos = Proceso::all();

        $response = compact('proyectosterm', 'procesos', 'proyectosproc', 'proyectosxcert', 'proyectospau', 'proyectoscan');

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validationRules = [
          'proy_nombre' => 'required',
          'proy_proc_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $proyecto = Proyecto::create($request->all());

        $proceso = Proceso::with('actividades.predecesoras')
                          ->where('id', $request->proy_proc_id)
                          ->first();

        foreach ($proceso->actividades as $actividad){
          $estado  = 'Pendiente';
          $date = NULL;

          if(count($actividad->predecesoras) == 0){
            $estado  = 'En Proceso';
            $date = Carbon::now();
          }

          $desarrollo = new Desarrollo;
          $desarrollo->dac_proy_id = $proyecto->id;
          $desarrollo->dac_act_id = $actividad->id;
          $desarrollo->dac_fecha_inicio = $date;
          $desarrollo->dac_estado = $estado;
          $desarrollo->save();
        }

        return response()->json($proceso);
    }

    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->proy_nombre = $request->proy_nombre;
        $proyecto->proy_proc_id = $request->proy_proc_id;
        $proyecto->save();

        return response()->json($proyecto);
    }

    public function pausar($id)
    {
        return Proyecto::where('id', $id)->update(['proy_estado' => 'Pausado']);
    }

    public function cancelar($id)
    {
        return Proyecto::where('id', $id)->update(['proy_estado' => 'Cancelado']);
    }

    public function activar($id)
    {
        return Proyecto::where('id', $id)->update(['proy_estado' => 'En Proceso']);
    }
}
