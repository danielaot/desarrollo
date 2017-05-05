<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TMarca as Marca;
use App\Models\Genericas\Itemcriteriomayor as Criterio;

class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Marcas';
        $titulo = 'Administración de Marcas';

        return view('layouts.pricat.catalogos.indexMarcas', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
