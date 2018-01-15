<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\tccws\TClientesBoomerang as Cliente;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TCliente;
use App\Models\Genericas\TSucursal;
ini_set('max_execution_time', 300);

class cliboomerangController extends Controller
{
    /**
     * Display a listing of the resource.
     *1
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "SGA // CLIENTES CON BOOMERANG - TCC";
        $titulo = "Clientes con Boomerang - TCC";
        $response = compact('ruta', 'titulo');
        return view('layouts.tccws.Catalogos.clientesBoomerangindex', $response);
    }
        
    public function getInfo()
    {

        $cli = TSucursal::where('suc_txt_estado','ACTIVO')->with('clientetcc','clientetcc.tercerotcc', 'clientetcc.tercerotcc.boomerang')->get();     
        // $cli = Tercero::where('indxClienteTercero', '=', '1')->where('indxEstadoTercero', 
        // '=', '1')->with('boomerang','tclientetcc','tclientetcc.sucursalestcc')->get();
        $clientesAgregados = Cliente::with('tercero')->get();
        // $clientes = collect($cli)->filter(function($cliente, $key){
        // 	return (is_null($cliente->boomerang) && !is_null($cliente->tclientetcc));
        // })->flatten(1);
        $clientes = collect($cli)->filter(function($cliente, $key){
         return (is_null($cliente['clientetcc']['tercerotcc']['boomerang']) && $cliente['clientetcc']['tercerotcc']['indxClienteTercero'] == 1);
        })->flatten(1);


        $response = compact('clientes', 'clientesAgregados');
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
     //    return response()->json($data);
    	// $idsTerceros = collect($data)->pluck('idTercero')->all();
    	foreach ($data as $key => $tercero) {
    		$creacion = new Cliente;
    		$creacion->clb_idTercero = $tercero['clientetcc']['ter_id'];
            $creacion->clb_cod_sucursal = $tercero['suc_num_codigo'];
            $creacion->clb_nom_tercero = $tercero['suc_txt_nombre'];
    		$creacion->save();
    	}

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
      	$clientea = Cliente::find($id);
        $clientea->delete();
        return response()->json($clientea->trashed());  
    }

}