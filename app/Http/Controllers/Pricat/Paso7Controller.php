<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;
use Carbon\Carbon;
use Auth;
use Mail;

use App\Mail\DesarrolloActividad;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TMarca as Marca;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;
use App\Models\Pricat\TPredecesora as ActPre;
use App\Models\Pricat\TActividad as Actividad;

class Paso7Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';
        $titulo = 'Confirmación de descripciones';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $item = Item::with('detalles.uso','eanes')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        $response = compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'item');

        return view('layouts.pricat.actividades.paso7', $response);
    }

    public function getInfo(Request $request)
    {
        $vocabas = Vocabas::all();
        $marcas = Marca::distinct()->orderBy('mar_nombre')
                       ->get(['mar_nombre']);

        $response = compact('vocabas', 'marcas');

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $validationRules = [
          'proy' => 'required|numeric',
          'act' => 'required|numeric',
          'item' => 'required|numeric',
          'descorta' => 'required',
          'deslogyca' => 'required',
          'desbesa' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errores' => $validator->errors()]);
        }

        $itemdet = ItemDetalle::with('items')
                              ->where('ide_item', $request->item)
                              ->get()->first();

        $itemdet->ide_descorta = $request->descorta;
        $itemdet->ide_deslarga = $request->deslogyca;
        $itemdet->ide_descompleta = $request->desbesa;
        $itemdet->ide_uso = $request['uso']['id'];
        $itemdet->ide_marca = $request['marca']['mar_nombre'];
        $itemdet->ide_variedad = $request->varserie;
        $itemdet->ide_contenido = $request->contenido;
        $itemdet->ide_umcont = $request->contum;
        $itemdet->save();

        if ($itemdet['items']['ite_tproducto'] == '1301' && $itemdet->ide_linea != '3036' && $itemdet->ide_categoria != '2004') {
          DesarrolloCtrl::update($request->proy, $request->act);
          $url = url('pricat/desarrolloactividades');
        }else {

          $fecha = Carbon::now();

          $desarrollo = Desarrollo::where(['dac_proy_id' => $request->proy, 'dac_act_id' => $request->act])
                                  ->update(['dac_fecha_cumplimiento' => $fecha, 'dac_usuario' => Auth::user()->login, 'dac_estado' => 'Completado']);

          $actividaddesp = ActPre::with('actividades.areas.responsables.usuarios','actividadespre.areas.responsables.usuarios')
                              ->where('pre_act_pre_id', $request->act)
                              ->get();

          foreach($actividaddesp as $actividad){

            Desarrollo::where(['dac_proy_id' => $request->proy, 'dac_act_id' => 8])
                      ->update(['dac_fecha_inicio' => $fecha, 'dac_estado' => 'Completado']);

            Desarrollo::where(['dac_proy_id' => $request->proy, 'dac_act_id' => 9])
                      ->update(['dac_fecha_inicio' => $fecha, 'dac_estado' => 'En Proceso']);

            $usuarios = $actividad['actividades']['areas']['responsables']->pluck('usuarios.dir_txt_email');
            Mail::to($usuarios)->send(new DesarrolloActividad($actividad));

            $url = url('pricat/desarrolloactividades');
        }
      }
      return response($url, 200);
    }

    public function edit(Request $request, $proy){

      $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';
      $titulo = 'Confirmación de descripciones';
      $idproyecto = $proy;
      $idactividad = $request->act;

      $item = Item::with('detalles.uso','eanes')
                  ->where('ite_proy', $idproyecto)
                  ->get()->first();

      $response = compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'item');

      return view('layouts.pricat.actividades.paso7edit', $response);
    }
}
