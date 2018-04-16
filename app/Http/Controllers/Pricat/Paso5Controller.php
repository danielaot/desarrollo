<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;
use DB;

use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\BESA\AppwebPosarancelaria as Posarancelaria;
use App\Models\BESA\AppwebGrupoimpo as Grupoimpo;

class Paso5Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';
        $titulo = 'Asignación del Grupo Impositivo';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $grupoimpositivo = Grupoimpo::all();

        $item = Item::with('detalles.categoria','detalles.linea')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        $posarancelaria = Posarancelaria::where('id_pos_arancelaria', $item->detalles['ide_posarancelaria'])
                                        ->get()->first();

        return view('layouts.pricat.actividades.paso5', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'grupoimpositivo', 'posarancelaria', 'item'));
    }

    public function update(Request $request, $id)
    {
      $validationRules = [
        'proy' => 'required|numeric',
        'act' => 'required|numeric',
        'grupoimpo' => 'required'
      ];

      $validator = Validator::make($request->all(), $validationRules);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
      }

      ItemDetalle::where('ide_item', $id)
                 ->update(['ide_grupoimpositivo' => $request->grupoimpo]);

      DesarrolloCtrl::update($request->proy, $request->act);

      return redirect('pricat/desarrolloactividades');
    }

    public function edit(Request $request, $proy){

      $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';
      $titulo = 'Editar Asignación del Grupo Impositivo';
      $idproyecto = $proy;
      $idactividad = $request->act;

      $item = Item::with('detalles.categoria','detalles.linea','tipo')
                  ->where('ite_proy', $idproyecto)
                  ->get()->first();

      $itemDet = ItemDetalle::where('ide_item', $item['id'])
                 ->get();

      $grupoimpositivo = Grupoimpo::all();

      $grpImpo = Grupoimpo::where('cod_grupoimpo', $itemDet[0]['ide_grupoimpositivo'])
                                       ->get();

      $posarancelaria = Posarancelaria::where('id_pos_arancelaria', $item->detalles['ide_posarancelaria'])
                                        ->get()->first();

      return view('layouts.pricat.actividades.paso5edit', compact('ruta', 'titulo', 'idproyecto' ,'idactividad', 'grupoimpositivo', 'posarancelaria', 'item', 'grpImpo'));
    }

    public function editGrupo(Request $request){

      $validationRules = [
        'proy' => 'required|numeric',
        'act' => 'required|numeric',
        'grupoimpo' => 'required'
      ];

      $validator = Validator::make($request->all(), $validationRules);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
      }

      ItemDetalle::where('ide_item', $id)
                 ->update(['ide_grupoimpositivo' => $request->grupoimpo]);

      DesarrolloCtrl::update($request->proy, $request->act);

      return redirect('pricat/desarrolloactividades');
    }
}
