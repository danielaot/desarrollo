<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TCriteriosItem as CriteriosItem;
use App\Models\Genericas\Itemcriterioplan as Planes;

class CriteriosController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Criterios Por Item';
        $titulo = 'Administrar Criterios Por Item';

        return view('layouts.pricat.catalogos.indexCriteriosItem', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $planes = Planes::all();
        $criterios = CriteriosItem::with('planes')->get();

        $response = compact('criterios', 'planes');

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validationRules = [
          'cri_plan' => 'required',
          'cri_regular' => 'sometimes|required',
          'cri_estuche' => 'sometimes|required',
          'cri_oferta' => 'sometimes|required',
          'cri_col_unoe' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $criterioitem = CriteriosItem::create($request->all());

        return response()->json($criterioitem);
    }
}
