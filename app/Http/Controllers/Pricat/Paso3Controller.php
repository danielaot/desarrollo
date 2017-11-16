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

        if(count($listamat) > 0)
         DesarrolloCtrl::update($request->proy, $request->act);

         return redirect('pricat/desarrolloactividades');
        // DesarrolloCtrl::update($request->proy, $request->act);
        // return (DesarrolloCtrl::update($request->proy, $request->act));
    }
}
