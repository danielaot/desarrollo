<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TCriteriosItem as CriteriosItem;
use App\Models\Genericas\Itemcriterioplan as Planes;

class CriteriosController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Criterios Por Item';
        $titulo = 'Administrar Criterios Por Item';

        return view('layouts.pricat.catalogos.indexCriteriosItem', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $planes = Planes::all();
        $criterios = CriteriosItem::with('planes')->get();

        $response = compact('criterios', 'planes');

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validationRules = [
          'cri_plan' => 'unique:pricat.t_criterios_item,cri_plan|required',
          'cri_regular' => 'sometimes|required',
          'cri_estuche' => 'sometimes|required',
          'cri_oferta' => 'sometimes|required',
          'cri_col_unoe' => 'required',
          'cri_col_item' => 'required'
        ];

        if (isset($data['id'])) {
          $validationRules['cri_plan'] = 'required';
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        
        if (isset($data['id'])) {
          $criterioitem = CriteriosItem::find($data['id']);
          $criterioitem->cri_col_item = $data['cri_col_item'];
          $criterioitem->cri_col_unoe = $data['cri_col_unoe'];
          $criterioitem->cri_estuche = $data['cri_estuche'];
          $criterioitem->cri_oferta = $data['cri_oferta'];
          $criterioitem->cri_regular = $data['cri_regular'];
          $criterioitem->save();
        }else{
          $criterioitem = CriteriosItem::create($data);
        }       

        return response()->json($criterioitem);
    }
}
