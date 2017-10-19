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
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Procesos';
        $titulo = 'Administración de Procesos y Actividades';

        return view('layouts.pricat.catalogos.indexProcesos', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $procesos = Proceso::with('actividades.areas')->get();
        $areas = Area::with('responsables.usuarios')->get();
        $actividades = Actividad::with('predecesoras')->get();
        $usuarios = DirNacional::all();

        $response = compact('procesos', 'areas', 'actividades', 'usuarios');

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validationRules = [
          'pro_nombre' => 'required',
          'pro_descripcion' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $proceso = Proceso::create($request->all());

        return response()->json($proceso);
    }

    public function storeActividad(Request $request)
    {
        $validationRules = [
          'act_titulo' => 'required',
          'act_descripcion' => 'required',
          'act_ar_id' => 'required',
          'act_plantilla' => 'required'
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

    public function update(Request $request, $id)
    {
        $validationRules = [
          'pro_nombre' => 'required',
          'pro_descripcion' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json($validator->errors());
        }

        $proceso = Proceso::find($id);
        $proceso->pro_nombre = $request->pro_nombre;
        $proceso->pro_descripcion = $request->pro_descripcion;
        $proceso->save();

        return response()->json($proceso);
    }

    public function updateActividad(Request $request, $id)
    {
        $validationRules = [
          'act_titulo' => 'required',
          'act_descripcion' => 'required',
          'act_ar_id' => 'required',
          'act_plantilla' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json($validator->errors());
        }

        $actividad = Actividad::find($id);
        $actividad->act_titulo = $request->act_titulo;
        $actividad->act_descripcion = $request->act_descripcion;
        $actividad->act_ar_id = $request->act_ar_id;
        $actividad->act_plantilla = $request->act_plantilla;
        $actividad->save();

        $actividad->predecesoras()->delete();

        if($request->pre_act_pre_id != '')
          $actividad->predecesoras()->create(['pre_act_id' => $actividad->id, 'pre_act_pre_id' => $request->pre_act_pre_id]);

        return response()->json($actividad);
    }

    public function destroy($id)
    {
        Proceso::where('id', $id)->delete();
    }

    public function destroyActividad($id)
    {
        Actividad::where('id', $id)->delete();
    }
}
