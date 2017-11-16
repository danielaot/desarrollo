<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TMarca as Marca;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;

class Paso7Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Confirmación de descripciones';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $item = Item::with('detalles.uso','eanes')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        $response = compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'item');

        return view('layouts.pricat.actividades.paso7edit', $response);
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

        $itemdet = ItemDetalle::where('ide_item', $request->item)
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
        DesarrolloCtrl::update($request->proy, $request->act);

        $url = url('pricat/desarrolloactividades');
        return response($url, 200);
    }

    public function edit(Request $request, $proy){

      $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
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
