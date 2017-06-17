<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;
use DB;

use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as IDetalle;

class Paso4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Asignación de Posición Arancelaria';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $posarancelaria = DB::connection('besa')
                            ->table('9000-appweb_posarancelaria')
                            ->get();

        $item = Item::with('detalles.categoria','detalles.linea','tipo')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        return view('layouts.pricat.actividades.paso4', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'posarancelaria', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

      IDetalle::where('ide_item', $id)
              ->update(['ide_posarancelaria' => $request->arancelaria]);

      DesarrolloCtrl::update($request->proy, $request->act);

      return redirect('pricat/desarrolloactividades');
    }
}
