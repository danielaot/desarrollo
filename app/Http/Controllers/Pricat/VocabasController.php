<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TVocabas as Vocabas;

class VocabasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Vocabas';
        $titulo = 'Administración de Vocabas';

        return view('layouts.pricat.catalogos.indexVocabas', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $vocabas = Vocabas::all();

        $response = compact('vocabas');

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
          'tvoc_palabra' => 'required',
          'tvoc_abreviatura' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $palabra = Vocabas::create($request->all());

        return response()->json($palabra);
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
          'tvoc_palabra' => 'required',
          'tvoc_abreviatura' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $palabra = Vocabas::find($id);
        $palabra->tvoc_palabra = $request->tvoc_palabra;
        $palabra->tvoc_abreviatura = $request->tvoc_abreviatura;
        $palabra->save();

        return response()->json($palabra);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     return Vocabas::where('id', $id)->delete();
    // }
}
