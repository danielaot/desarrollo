<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Uuid;

use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\Pricat\TFotos as Fotos;

ini_set('memory_limit', '-1');

class FotosController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Proyectos';
        $titulo = 'Fotos Producto Terminado';

        return view('layouts.pricat.actividades.indexFotos', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {

        $referencias = Item::all();

        $response = compact('referencias');

        return response()->json($response);
    }

    public function store(Request $request)
    {
      return response()->json($request);
      // $validationRules = [
      //   'foto' => 'required|file'
      // ];
      //
      // $validator = Validator::make($request->all(), $validationRules);
      //
      // if ($validator->fails()){
      //   return response()->json(['errors' => $validator->errors()]);
      // }

        if ($request->hasFile('imagen')){
          $filePath = '/public/pricat/prodterminado/';
          $file = $request->file('imagen');
          $fileName = Uuid::uuid4().'.'.$file->getClientOriginalExtension();
          $file->storePubliclyAs($filePath, $fileName);

          $fotos = new Fotos;
          $fotos->fot_id_item = $request->referencia['ite_referencia'];
          $fotos->fot_fotos = $filePath.$fileName;

        }
    }
}
