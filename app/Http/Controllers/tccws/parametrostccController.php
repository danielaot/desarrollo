<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\tccws\TParametros as Parametro;

class parametrostccController extends Controller
{
    /**
     * Display a listing of the resource.
     *1
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "SGA // PARAMETROS TCCWS";
        $titulo = "Parametros TCCWS";
        $response = compact('ruta', 'titulo');
        return view('layouts.tccws.Catalogos.parametrosIndex', $response);
    }
        
    public function getInfo()
    {
        $parametros = Parametro::all();
        $response = compact('parametros');
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['par_campoVariable'] = $data['par_campoTcc'];
        $creacion = Parametro::create($data);
        return response()->json($creacion);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $parametro = Parametro::find($id);
        $data = $request->all();
        $parametro->par_valor = $data['par_valor'];
        $parametro->par_grupo = $data['par_grupo'];
        $parametro->save();

        return response()->json($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parametro = Parametro::find($id);
        $parametro->delete();
        return response()->json($parametro->trashed());
    }

}