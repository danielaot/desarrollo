<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Genericas\TDirNacional as DirNacional;
use App\Models\Pricat\TResponsable as Responsable;
use App\Models\Pricat\TArea as Area;

class ResponsablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Catalogos // Administrar Responsables';
        $titulo = 'Administración de Áreas y Responsables';

        return view('layouts.pricat.catalogos.indexResponsables', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $areas = Area::with('responsables.usuarios')->get();
        $usuarios = DirNacional::all();

        $response = compact('areas', 'usuarios');

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
          'ar_nombre' => 'required',
          'ar_descripcion' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $area = Area::create($request->all());

        foreach ($request->responsables as $usuario){
          $responsable = new Responsable;
          $responsable->res_usuario = $usuario['dir_txt_cedula'];
          $responsable->res_ar_id = $area->id;
          $responsable->save();
        }

        return response()->json($area);
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
        $area = Area::find($id);
        $area->ar_nombre = $request->ar_nombre;
        $area->ar_descripcion = $request->ar_nombre;
        $area->save();

        Responsable::where('res_ar_id', $id)->delete();

        foreach ($request->responsables as $usuario){
          $responsable = new Responsable;
          $responsable->res_usuario = $usuario['dir_txt_cedula'];
          $responsable->res_ar_id = $area->id;
          $responsable->save();
        }

        return response()->json($area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Area::where('id', $id)->delete();
    }
}
