<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

use App\Models\Pricat\TDesarrolloActividad as Desarrollo;
use App\Models\Pricat\TPredecesora as ActPre;

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

        $actdespues = ActPre::where('pre_act_pre_id', $act)->get();

        foreach($actdespues as $actividad){
          Desarrollo::where(['dac_proy_id' => $proy, 'dac_act_id' => $actividad->pre_act_id])
                    ->update(['dac_fecha_inicio' => $fecha, 'dac_estado' => 'En Proceso']);
        }

        return $desarrollo;
    }
}
