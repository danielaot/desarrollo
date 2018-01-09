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
use App\Models\Pricat\TPredecesora as ActPre;

class Paso4Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';
        $titulo = 'Asignación de Posición Arancelaria';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $posarancelaria = Posarancelaria::all();

        $item = Item::with('detalles.categoria','detalles.linea','tipo')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        return view('layouts.pricat.actividades.paso4', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'posarancelaria', 'item'));
    }

    public function update(Request $request, $id)
    {
      $validationRules = [
        'proy' => 'required|numeric',
        'act' => 'required|numeric',
        'arancelaria' => 'required'
      ];

      $validator = Validator::make($request->all(), $validationRules);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
      }

      ItemDetalle::where('ide_item', $id)
                 ->update(['ide_posarancelaria' => $request->arancelaria]);

      DesarrolloCtrl::update($request->proy, $request->act);

      return redirect('pricat/desarrolloactividades');
    }

    public function edit(Request $request, $proy){

      $act = $request->act;
      $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';

      $titulo = 'Editar Asignación de Posición Arancelaria';

      $item = Item::with('detalles.categoria','detalles.linea','tipo')
                  ->where('ite_proy', $proy)
                  ->get()->first();
      $idItem = $item['id'];

      $itemDet = ItemDetalle::where('ide_item', $idItem)
                 ->get();

      $idPosAran = $itemDet[0]['ide_posarancelaria'];

      $posarancelaria = Posarancelaria::all();
      $posaran = Posarancelaria::where('id_pos_arancelaria', $idPosAran)
                                       ->get();

      return view('layouts.pricat.actividades.paso4edit', compact('ruta', 'titulo', 'proy' ,'act' ,'item','itemDet', 'posarancelaria', 'posaran'));
    }

    public function editPosicion(Request $request, $id)
    {
      $validationRules = [
        'arancelaria' => 'required'
      ];

      $validator = Validator::make($request->all(), $validationRules);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
      }

      ItemDetalle::where('ide_item', $id)
                 ->update(['ide_posarancelaria' => $request->arancelaria]);

      DesarrolloCtrl::update($request->proy, $request->act);

      return redirect('pricat/desarrolloactividades');

    }
}
