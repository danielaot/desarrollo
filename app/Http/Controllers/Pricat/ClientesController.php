<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TCliente as Cliente;
use App\Models\Genericas\Tercero;
use App\Models\BESA\AppwebListaPrecio as ListaPrecio;

class ClientesController extends Controller
{
    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Catalogos // Administrar Clientes Pricat';
        $titulo = 'Administrar Clientes Pricat';

        return view('layouts.pricat.catalogos.indexClientes', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {

        $clientes = Cliente::withTrashed()->with('terceros', 'kam', 'listaprecio')->get();
        $agrupadoClientes = $clientes->groupBy('cli_nit');
        $agrupadoClientes = $agrupadoClientes->keys()->all();

        $terceros = Tercero::whereNotIn('idTercero', $agrupadoClientes)->get();

        $listaprecio = ListaPrecio::where('f112_ind_estado', 1)->get();
        $response = compact('terceros','clientes', 'agrupadoClientes', 'listaprecio');

        return response()->json($response);
    }

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
        $cliente->cli_listaprecio = $request->lista['f112_id'];
        $cliente->save();

        return response()->json($cliente);
    }

    public function update(Request $request, $id)
    {
        $validationRules = [
            'cli_nit' => 'required',
            'kam' => 'required',
            'gln' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $cliente = Cliente::find($id);
        $cliente->cli_nit = $request->cli_nit;
        $cliente->cli_codificacion = $request->codificacion ? true : false;
        $cliente->cli_modificacion = $request->modificacion ? true : false;
        $cliente->cli_eliminacion = $request->eliminacion ? true : false;
        $cliente->cli_kam = $request->kam['idTercero'];
        $cliente->cli_gln = $request->gln;
        $cliente->cli_listaprecio = $request->lista['f112_id'];
        $cliente->save();

        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::withTrashed()->find($id);
        if ($cliente->trashed()) {
            $cliente->restore();
        }else{
            $cliente->delete();
        }
        return response()->json($cliente->trashed());
    }
}
