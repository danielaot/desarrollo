<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Genericas\TDirNacional as DirNacional;
use App\Models\Pricat\TResponsable as Responsable;
use App\Models\Pricat\TActividad as Actividad;
use App\Models\Pricat\TNotiActividad as NotiActividad;

class NotiActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Catalogos // Administrar Notificaciones';
        $titulo = 'Administración de Notificación por Actividad';

        return view('layouts.pricat.catalogos.indexNotiactividad', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $actividad = Actividad::all();
        $usuarios = DirNacional::all();
        $noti = Actividad::with('notiactividad.usuarios')->get();

        $notificacion = $noti->filter(function($notifi){
          return !($notifi->notiactividad)->isEmpty();
        })->all();

        $response = compact('actividad', 'usuarios', 'notificacion');

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validationRules = [
          'responsables' => 'required',
          'actividad' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        foreach ($request->responsables as $usuario){
          $notificacion = new NotiActividad;
          $notificacion->not_usuario = $usuario['dir_txt_cedula'];
          $notificacion->not_actividad = $request->actividad['id'];
          $notificacion->save();
        }
        return response()->json($notificacion);
    }

    public function update(Request $request, $id)
    {
        $actividad = Actividad::find($request['actividad']['id']);
        $act = NotiActividad::where('not_actividad', $actividad->id)->delete('not_usuario');
        foreach ($request->responsables as $usuario){
          $notificacion = new NotiActividad;
          $notificacion->not_usuario = $usuario['dir_txt_cedula'];
          $notificacion->not_actividad = $actividad->id;
          $notificacion->save();
        }
        return response()->json($notificacion);
    }

    public function destroy($id)
    {
        return Area::where('id', $id)->delete();
    }
}
