<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TCampSegmento as Segmento;

class SegmentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Catalogos // Administrar Segmentos Pricat';
        $titulo = 'Administrar Segmentos Pricat';

        return view('layouts.pricat.catalogos.indexSegmentos', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $segmentos = Segmento::where([['cse_grupo', '<>', 'a'], ['cse_grupo', '<>', 'z']])
                             ->get()
                             ->groupBy('cse_tnovedad');

        $encabezado = Segmento::where('cse_grupo', 'a')
                              ->get();

        $cierre = Segmento::where('cse_grupo', 'z')
                              ->get();

        $response = compact('encabezado', 'cierre', 'segmentos');

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
          'cse_grupo' => 'required',
          'cse_nombre' => 'required',
          'cse_segmento' => 'required',
          'cse_tnovedad' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $orden = Segmento::where(['cse_grupo' => $request->grupo, 'cse_tnovedad' => $request->tnovedad])
                          ->get()->count();

        $segmento = new Segmento;
        $segmento->cse_nombre = $request->cse_nombre;
        $segmento->cse_campo = $request->cse_campo;
        $segmento->cse_segmento = $request->cse_segmento;
        $segmento->cse_orden = $orden+1;
        $segmento->cse_grupo = $request->cse_grupo;
        $segmento->cse_tnovedad = $request->cse_tnovedad;
        $segmento->save();

        return response()->json($segmento);
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
          'cse_grupo' => 'required',
          'cse_nombre' => 'required',
          'cse_segmento' => 'required',
          'cse_tnovedad' => 'required',
          'cse_orden' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $segmento = Segmento::find($id);
        $segmento->cse_nombre = $request->cse_nombre;
        $segmento->cse_campo = $request->cse_campo;
        $segmento->cse_segmento = $request->cse_segmento;
        $segmento->cse_grupo = $request->cse_grupo;
        $segmento->cse_tnovedad = $request->cse_tnovedad;
        $segmento->save();

        return response()->json($segmento);
    }
}
