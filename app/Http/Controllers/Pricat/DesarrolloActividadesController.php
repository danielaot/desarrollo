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



class DesarrolloActividadesController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Desarrollo de Actividades';

        $response = compact('ruta', 'titulo');

        return view('layouts.pricat.actividades.indexDesarrollo', $response);
    }

    public function desarrolloactividadesGetInfo(){

      $desarrollos = Desarrollo::with('proyectos', 'actividades.predecesoras')
                                ->where('dac_estado', "En Proceso")
                                ->whereHas('actividades.areas.responsables', function ($query) {
                                            $query->where('res_usuario', Auth::user()->idTerceroUsuario);
                                          })
                               ->get()
                               ->groupBy('dac_proy_id');

      foreach ($desarrollos as $key => $value) {
        $collection = collect($value);
        $value = $collection->map(function($item, $key2){
          $act = $item->dac_act_id;
          $proy = $item->dac_proy_id;
          if ($item['dac_rechazo'] == null) {
            $url = route($item['actividades']['act_plantilla'] . ".index", ['proy' => $proy, 'act' => $act ]);
           }else{
             $url = route($item['actividades']['act_plantilla'] . ".edit", ['proy' => $proy, 'act' => $act ]);
           }
           $item->url = $url;
        });
      }

      $actividades = Actividad::with('predecesoras')
                              ->get();

      $response = compact('desarrollos', 'actividades');
      return response()->json($response);

    }

    public function store(Request $request){

      $rechazos = new Rechazo;
      foreach ($request->selected as $key => $value) {
        $idActividad = $value['id'];
      }
      $rechazos->rec_id_proy = $request->proyecto;
      $rechazos->rec_id_act = $idActividad;
      $rechazos->rec_observacion = $request->observacion;
      $rechazos->save();

      return response()->json($rechazos->save());
    }

    public static function update($proy, $act)
    {
        $fecha = Carbon::now();

        $proyecto = Proyecto::find($proy);

        $desarrollo = Desarrollo::where(['dac_proy_id' => $proy, 'dac_act_id' => $act])
                                ->update(['dac_fecha_cumplimiento' => $fecha, 'dac_usuario' => Auth::user()->login, 'dac_estado' => 'Completado']);


        $actividaddesp = ActPre::with('actividades.areas.responsables.usuarios','actividadespre.areas.responsables.usuarios')
                            ->where('pre_act_pre_id', $act)
                            ->get();

        foreach($actividaddesp as $actividad){
          Desarrollo::where(['dac_proy_id' => $proy, 'dac_act_id' => $actividad->pre_act_id])
                    ->update(['dac_fecha_inicio' => $fecha, 'dac_estado' => 'En Proceso']);

          $actividad['proyecto'] = $proyecto['proy_nombre'];
          $usuarios = $actividad['actividades']['areas']['responsables']->pluck('usuarios.dir_txt_email');
          Mail::to($usuarios)->send(new DesarrolloActividad($actividad));

        }

        return $desarrollo;
    }

    public function workflow()
    {
        $ruta = 'Calidad de Datos y Homologación // WorkFlow';
        $titulo = 'WorkFlow';

        $proyectos = Proyecto::all();

        $estilos = ['btn-primary','btn-success','btn-danger','btn-warning'];

        $response = compact('ruta', 'titulo', 'proyectos', 'estilos');

        return view('layouts.pricat.actividades.indexWorkFlow', $response);
    }

    public function getInfo()
    {
        $proyectos = Proyecto::with('desarrollos.actividades')
                             ->get();

        $estilos = ['btn-primary','btn-success','btn-danger','btn-warning'];

        $response = compact('proyectos', 'estilos');

        return response()->json($response);
    }
}
