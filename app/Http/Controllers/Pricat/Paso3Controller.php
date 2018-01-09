<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use DB;

use App\Models\Pricat\TItem as Item;
use App\Models\BESA\AppwebListaMateriales as ListaMateriales;

class Paso3Controller extends Controller
{
    public function index(Request $request)
    {
        $item = Item::where('ite_proy', $request->proy)
                    ->get()->first();

        $listamat = ListaMateriales::where('Cod_Item', $item->ite_referencia)
                                   ->get()->first();

        if(count($listamat) > 0){
          DesarrolloCtrl::update($request->proy, $request->act);
        }else {
          $ruta = 'Plataforma Integral de Creación de Items // Desarrollo de Actividades';
          $titulo = 'Desarrollo de Actividades';
          $error = 'Error en este modulo';
          return view('layouts.pricat.actividades.indexDesarrollo', compact('error', 'ruta', 'titulo'));
        }
        return redirect('pricat/desarrolloactividades');


    }
}
