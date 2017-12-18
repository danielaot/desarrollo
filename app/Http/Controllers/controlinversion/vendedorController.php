<?php

namespace App\Http\Controllers\controlinversion;

use App\Models\BESA\VendedorZona;
use App\Models\BESA\Vendedores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use DB;

class vendedorController extends Controller
{

   public function getInfo(){

     $vendedoresZona = VendedorZona::orderBy('id','desc')->get();
     $zonas = VendedorZona::select('CodZona','NomZona')->distinct()->get();
     $subzonas = VendedorZona::select('CodZona','CodSubZona','NomSubZona')->distinct()->get();

     $codigosVendedores = [];
     foreach ($vendedoresZona as $key => $value) {
       $codigosVendedores[$key] = $value->CodVendedor;
     }

     $vendedoresBesa = Vendedores::whereNotIn('CodVendedor', $codigosVendedores)->get();

     $response = compact('vendedoresZona','zonas','subzonas','vendedoresBesa');

     return response()->json($response);

   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $ruta = 'Control de Inversion // Gestion de Vendedores por Zonas';
      $titulo = 'Gestion de Vendedores';
      return view('layouts.controlinversion.vendedores.indexVendedores', compact('ruta','titulo'));
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
      $validationRules = [
        'vendedores' => 'required'
      ];

      $validator = Validator::make($request->all(), $validationRules);

      if ($validator->fails()){
        return response()->json(['errors' => $validator->errors()]);
      }else{

        foreach ($request->vendedores as $vendedor) {

            if($vendedor['esNuevo'] === 1){
                $vendedorZona = new VendedorZona;
                $vendedorZona->CodVendedor = $vendedor['CodVendedor'];
                $vendedorZona->NitVendedor = $vendedor['NitVendedor'];
                $vendedorZona->NomVendedor = $vendedor['NomVendedor'];
                $vendedorZona->CodZona = $vendedor['CodZona'];
                $vendedorZona->NomZona = $vendedor['NomZona'];
                $vendedorZona->CodSubZona = $vendedor['CodSubZona'];
                $vendedorZona->NomSubZona = $vendedor['NomSubZona'];
                $vendedorZona->CodSubZona_ant = $vendedor['CodSubZona_ant'];
                $vendedorZona->NomSubZona_ant = $vendedor['NomSubZona_ant'];
                $vendedorZona->dir_territorio = $vendedor['dir_territorio'];
                $vendedorZona->ger_zona = $vendedor['ger_zona'];
                $vendedorZona->estado = $vendedor['estado'];
                $vendedorZona->save();
            }

            if($vendedor['existente'] === 1){
              if($vendedor['estadoModificado'] != $vendedor['estado']){
                $vendedorToUpdate = VendedorZona::find($vendedor['id']);
                $vendedorToUpdate->estado = $vendedor['estadoModificado'];
                $vendedorToUpdate->save();
              }
            }

        }

        return response()->json($request->all());
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function show(VendedorZona $vendedorZona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function edit(VendedorZona $vendedorZona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendedorZona $vendedorZona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendedorZona $vendedorZona)
    {
        //
    }
}
