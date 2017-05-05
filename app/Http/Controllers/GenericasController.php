<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Genericas\TDirNacional as DirNacional;
use App\Models\Genericas\Tercero;

class GenericasController extends Controller
{
    //Funcion para autocompletado de proveedores
    public function autocomplete(Request $request){
        $term = $request->term;

        /*$response = Tercero::where('nitTercero', 'LIKE', '%'.$term.'%')
                           ->orWhere('razonSocialTercero', 'LIKE', '%'.$term.'%')
                           ->take(10)
                           ->get();*/

        $response = DirNacional::where('dir_txt_cedula', 'LIKE', '%'.$term.'%')
                               ->orWhere('dir_txt_nombre', 'LIKE', '%'.$term.'%')
                               ->take(10)
                               ->get();

        return response()->json($response);
    }
}
