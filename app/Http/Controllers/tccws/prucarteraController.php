<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\tccws\TPruebaCartera as Cartera;
use Excel;

class prucarteraController extends Controller
{
    public $response;
    /**
     * Display a listing of the resource.
     *1
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "SGA // PRUEBA CARTERA";
        $titulo = "Prueba Cartera";
        $url = route('reporte');
        $response = compact('ruta', 'titulo', 'url');
        return view('layouts.tccws.pruebaCarteraIndex', $response);
    }
        
    public function getInfo()
    {
        $pruebas = Cartera::orderBy('prc_numero')->get();
        $response = compact('pruebas');
        return response()->json($response);
    }

    public function generarReporte()
    {
        // return view('layouts.tccws.generarReporte');
        $pruebas = Cartera::orderBy('prc_numero')->get();
        $this->response = compact('pruebas');
        Excel::create('reporte', function($excel) {
            $excel->sheet('Hoja 1', function($sheet) {
                $sheet->loadView('layouts.tccws.generarReporte', $this->response);
            });
        })->download('xlsx');
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
        $data['prc_suma'] = ($data['prc_numero']*2);
        $data['prc_formulas'] = ($data['prc_suma']*3);
        $creacion = Cartera::create($data);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prueba = Cartera::find($id);
        $prueba->delete();
        return response()->json($prueba->trashed());
      	
    }

}