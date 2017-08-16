<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use Mail;

use App\Mail\DesarrolloActividad;

use App\Models\Aplicativos\User;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;
use App\Models\Pricat\TPredecesora as ActPre;
use App\Models\Pricat\TProyecto as Proyecto;

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

        $response = compact('ruta', 'titulo','desarrollos');

        return view('layouts.pricat.actividades.indexDesarrollo', $response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function update($proy, $act)
    {
        $fecha = Carbon::now();

        $desarrollo = Desarrollo::where(['dac_proy_id' => $proy, 'dac_act_id' => $act])
                                ->update(['dac_fecha_cumplimiento' => $fecha, 'dac_usuario' => Auth::user()->login, 'dac_estado' => 'Completado']);

        $actividaddesp = ActPre::with('actividades.areas.responsables.usuarios','actividadespre.areas.responsables.usuarios')
                            ->where('pre_act_pre_id', $act)
                            ->get();

        foreach($actividaddesp as $actividad){
          Desarrollo::where(['dac_proy_id' => $proy, 'dac_act_id' => $actividad->pre_act_id])
                    ->update(['dac_fecha_inicio' => $fecha, 'dac_estado' => 'En Proceso']);

          $usuarios = $actividad['actividades']['areas']['responsables']->pluck('usuarios.dir_txt_email');
          Mail::to($usuarios)->send(new DesarrolloActividad($actividad));
        }

        return $desarrollo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workflow()
    {
        $ruta = 'Calidad de Datos y Homologación // WorkFlow';
        $titulo = 'WorkFlow';

        $proyectos = Proyecto::all();

        $estilos = ['btn-primary','btn-success','btn-danger','btn-warning'];

        $response = compact('ruta', 'titulo', 'proyectos', 'estilos');

        return view('layouts.pricat.actividades.indexWorkFlow', $response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $proyectos = Proyecto::with('desarrollos.actividades')
                             ->get();

        $estilos = ['btn-primary','btn-success','btn-danger','btn-warning'];

        $response = compact('proyectos', 'estilos');

        return response()->json($response);
    }
}
