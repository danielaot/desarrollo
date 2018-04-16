<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;
use Auth;

use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TSolSubempaque as SolSubempaque;

class SubempaqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';
        $titulo = 'Solicitud Creación Subempaque';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        return view('layouts.pricat.actividades.createSubempaque', compact('ruta', 'titulo', 'idproyecto', 'idactividad'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $items = Item::with('detalles')->get();

        $response = compact('items');

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
          'proy' => 'required',
          'act' => 'required',
          'referencia' => 'required',
          'embalaje' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $solicitud = new SolSubempaque;
        $solicitud->ssu_proy = $request->proy;
        $solicitud->ssu_item = $request->referencia['id'];
        $solicitud->ssu_cantemb = $request->embalaje;
        $solicitud->ssu_user = Auth::user()->login;
        $solicitud->save();

        DesarrolloCtrl::update($request->proy, $request->act);

        $url = url('pricat/desarrolloactividades');
        return response($url, 200);
    }
}
