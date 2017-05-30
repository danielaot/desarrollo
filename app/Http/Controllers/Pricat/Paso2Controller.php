<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TItem as Item;

class Paso2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Confirmación de Creación de Item';
        $idproyecto = $request->proy;
        $idactividad = $request->act;
        $item = Item::with('detalles.origen','detalles.tipomarcas','detalles.tipooferta','detalles.menuprom',
                           'detalles.tipoprom','detalles.presentacion','detalles.variedad','detalles.categoria',
                           'detalles.linea','detalles.sublinea','detalles.submercadeo','detalles.submercadeo2',
                           'detalles.submarca','detalles.regalias','detalles.segmento','detalles.clasificacion',
                           'detalles.acondicionamiento','tipo','eanes')
                    ->where('ite_proy', $request->proy)
                    ->get()
                    ->first();

        $tipo = $item['tipo']['descripcionItemCriterioMayor'];
        $categoria = $item['detalles'][0]['categoria']['descripcionItemCriterioMayor'];

        return view('layouts.pricat.actividades.paso2', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'tipo', 'categoria', 'item'));
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
      $validationRules = [
        'proy' => 'required',
        'act' => 'required',
        'ean13' => 'required|number',
        'ean14' => 'required|number'
      ];

      $validator = Validator::make($request->all(), $validationRules);

      if ($validator->fails()) {
        return response()->json($validator->errors());
      }

      $url = url('pricat/desarrolloactividades');
      return response($url, 200);
    }
}
