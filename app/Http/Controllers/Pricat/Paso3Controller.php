<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use DB;

use App\Models\Pricat\TItem as Item;

class Paso3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item = Item::where('ite_proy', $request->proy)
                    ->get()->first();

        $listamat = DB::connection('besa')
                      ->table('9000-appweb_lista_materiales')
                      ->where('Cod_Item', $item->ite_referencia)
                      ->get()->first();

        if(count($listamat) > 0)
          DesarrolloCtrl::update($request->proy, $request->act);

        return redirect('pricat/desarrolloactividades');
    }
}
