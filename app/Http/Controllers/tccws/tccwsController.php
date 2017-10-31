<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wms\UPL_ORDERS;
use Carbon\Carbon;

class tccwsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "SGA // AGRUPAR REMESA";
        $titulo = "Agrupar remesa";
        $response = compact('ruta', 'titulo');
        return view('layouts.tccws.pedidosAgruparIndex', $response);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agrupaPedidosGetInfo()
    {
        // F47 se consulta distinto el cliente
        $fecha = Carbon::now()->subDays(3);
        $pedidos = UPL_ORDERS::select('A01', 'A09', 'A08', 'A22', 'A29', 'A07')
        ->with('infoFactura')
        ->where('KEY5', '<>', 'MASTER')
        ->where('F01', '>', $fecha)
        ->get();

        $pedidosConcliente = [];
        $pedidosSinCliente = [];

        foreach ($pedidos as $key => $value) {
            if($value['infoFactura'] == null){
                array_push($pedidosSinCliente, $value);
            }elseif($value['infoFactura'] != null){
                array_push($pedidosConcliente, $value['infoFactura']);
            }
        }

        $pedidosConcliente = collect($pedidosConcliente)->groupBy('f_nit_tercero');
            
        // $pedidos = $pedidos->groupBy("{ info_factura : f_nit_tercero }");
        $response = compact('pedidosConcliente', 'pedidosSinCliente');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
