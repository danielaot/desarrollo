<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TCliente as Cliente;
use App\Models\Genericas\Tercero;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Clientes Pricat';
        $titulo = 'Administrar Clientes Pricat';

        return view('layouts.pricat.catalogos.indexClientes', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $terceros = Tercero::all();
        $clientes = Cliente::all();

        $response = compact('terceros','clientes');

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
          'tercero' => 'required',
          'kam' => 'required',
          'gln' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $cliente = new Cliente;
        $cliente->cli_nit = $request->tercero['nitTercero'];
        $cliente->cli_codificacion = $request->codificacion ? true : false;
        $cliente->cli_modificacion = $request->modificacion ? true : false;
        $cliente->cli_eliminacion = $request->eliminacion ? true : false;
        $cliente->cli_kam = $request->kam['idTercero'];
        $cliente->cli_gln = $request->gln;
        $cliente->save();

        return response()->json($cliente);
    }
}
