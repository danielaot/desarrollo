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
use App\Models\Pricat\TActividad as Actividad;
use App\Models\Pricat\TRechazos as Rechazo;

class RechazoActividadesController extends Controller
{
    public $info;
    public $datos;

    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Rechazo de Actividades';
        $titulo = 'Rechazo de Actividades';

        $response = compact('ruta', 'titulo');

        return view('layouts.pricat.actividades.indexRechazo', $response);
    }

     public function getInfo(){

       $rechazos = Rechazo::with('actividades.predecesoras.actividadespre', 'proyecto.proyectos', 'actividades.areas.responsables')
                           ->whereHas('actividades.areas.responsables', function ($query) {
                                       $query->where('res_usuario', Auth::user()->idTerceroUsuario);
                                     })
                          ->get()
                          ->groupBy('rec_id_proy');

        $actividades = Actividad::with('predecesoras')
                                ->get();

        $arrayDatos = [];
        $this->info = [];

        foreach ($rechazos as $key => $value) {
          foreach ($value as $key2 => $value2) {
            $infoCompleta = $value2;
            $idProyecto = $value2['rec_id_proy'];
            $proyecto = $value2['proyecto']['proyectos']['proy_nombre'];
            $idActividad = $value2['rec_id_act'];
            $actividad = $value2['actividades']['act_titulo'];
            $area = $value2['actividades']['areas']['ar_nombre'];
            $responsable = $value2['actividades']['areas']['responsables'][0]['res_usuario'];

            $arrayDatos['idproyecto'] = $idProyecto;
            $arrayDatos['proyecto'] = $proyecto;
            $arrayDatos['idactividad'] = $idActividad;
            $arrayDatos['actividad'] = $actividad;
            $arrayDatos['area'] = $area;
            $arrayDatos['responsable'] = $responsable;
            $arrayDatos['infoCompleta'] = $infoCompleta;

            array_push($this->info, $arrayDatos);
            }
        }

        $datos = $this->info;

        $response = compact('datos', 'actividades');

        return response()->json($response);
     }

    public static function updateEstado(Request $request){

      $proy = $request->idproyecto;
      $act = $request->paso['id'];

      $fecha = Carbon::now();

      $proyecto = Proyecto::find($proy);

      $desarrollo = Desarrollo::where(['dac_proy_id' => $proy, 'dac_act_id' => $act])
                              ->update(['dac_fecha_cumplimiento' => $fecha, 'dac_usuario' => Auth::user()->login, 'dac_estado' => 'En Proceso',  'dac_rechazo' => 'Rechazado']);

      $actividaddesp = ActPre::with('actividades.areas.responsables.usuarios','actividadespre.areas.responsables.usuarios')
                              ->where('pre_act_pre_id', $act)
                              ->get();

      foreach($actividaddesp as $actividad){
        Desarrollo::where(['dac_proy_id' => $proy, 'dac_act_id' => $actividad->pre_act_id])
                  ->update(['dac_fecha_inicio' => $fecha, 'dac_estado' => 'Pendiente']);

        $actividad['proyecto'] = $proyecto['proy_nombre'];
        $usuarios = $actividad['actividades']['areas']['responsables']->pluck('usuarios.dir_txt_email');
        //Mail::to($usuarios)->send(new DesarrolloActividad($actividad));
      }
      return $desarrollo;

      }


    //
    // public function workflow()
    // {
    //     $ruta = 'Calidad de Datos y Homologación // WorkFlow';
    //     $titulo = 'WorkFlow';
    //
    //     $proyectos = Proyecto::all();
    //
    //     $estilos = ['btn-primary','btn-success','btn-danger','btn-warning'];
    //
    //     $response = compact('ruta', 'titulo', 'proyectos', 'estilos');
    //
    //     return view('layouts.pricat.actividades.indexWorkFlow', $response);
    // }
    //
    // public function getInfo()
    // {
    //     $proyectos = Proyecto::with('desarrollos.actividades')
    //                          ->get();
    //
    //     $estilos = ['btn-primary','btn-success','btn-danger','btn-warning'];
    //
    //     $response = compact('proyectos', 'estilos');
    //
    //     return response()->json($response);
    // }
}
