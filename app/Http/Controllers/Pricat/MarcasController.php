<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TMarca as Marca;
use App\Models\Genericas\Itemcriteriomayor as Criterio;

class MarcasController extends Controller
{
    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Catalogos // Administrar Marcas';
        $titulo = 'Administración de Marcas';

        return view('layouts.pricat.catalogos.indexMarcas', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $marcas = Criterio::where(['idItemCriterioPlanItemCriterioMayor' => '300', 'notaItemCriterioMayor' => 'Linea Activa'])
                          ->orderBy('descripcionItemCriterioMayor')
                          ->get()
                          ->groupBy('marcas.mar_nombre');


        $lineas = $marcas->first();
        $marcas->shift();

        $response = compact('marcas','lineas');

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validationRules = [
          'mar_nombre' => 'required|unique:pricat.t_marcas',
          'lineas' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        foreach ($request->lineas as $linea){
          $marca = new Marca;
          $marca->mar_nombre = strtoupper($request->mar_nombre);
          $marca->mar_linea = $linea['idItemCriterioMayor'];
          $marca->save();
        }

        return response()->json($request->lineas);
    }

    public function update(Request $request, $id)
    {

        $validationRules = [
          'mar_nombre' => 'sometimes|required|unique:pricat.t_marcas',
          'lineas' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        Marca::where('mar_nombre', $id)->delete();

        foreach ($request->lineas as $linea){
          $marca = new Marca;
          $marca->mar_nombre = $request->mar_nombre ? $request->mar_nombre : $id;
          $marca->mar_linea = $linea['idItemCriterioMayor'];
          $marca->save();
        }

        return response()->json($request->lineas);
    }
}
