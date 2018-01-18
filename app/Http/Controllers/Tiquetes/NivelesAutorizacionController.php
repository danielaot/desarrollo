<?php

namespace App\Http\Controllers\Tiquetes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Genericas\TTipopersona as TipoPersona;
use App\Models\Genericas\TCanal as Canal;
use App\Models\Genericas\TZona as Zona;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

class NivelesAutorizacionController extends Controller
{

    public function index()
    {
        $ruta = 'Tiquetes y Hotel // Niveles de Aprobación';
        $titulo = 'Niveles de Aprobación';
        return view('layouts.tiquetes.nivelesAutorizacion.indexNivelesAutorizacion', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
      $tpersona = TipoPersona::all();
      $canal = Canal::all();
      $zona = Zona::all();

      $response = compact('tpersona', 'canal', 'zona');

      return response()->json($response);
    }

}
