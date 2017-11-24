<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;

use App\Models\Pricat\TProyecto as Proyecto;
use App\Models\Pricat\TProceso as Proceso;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;

class ConsultaController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Proyectos';
        $titulo = 'Consulta de Referencias';

        return view('layouts.pricat.actividades.indexConsulta', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $proyectos = Proyecto::with('procesos')->get();

        $referencias = Item::with('detalles.notificacionsanitaria', 'tipo', 'detalles.uso',
                                  'detalles.logcategorias', 'detalles.origen', 'detalles.tipomarcas',
                                  'detalles.variedad', 'detalles.linea', 'detalles.submercadeo',
                                  'detalles.submarca', 'detalles.clase', 'detalles.presentacion',
                                  'detalles.categoria', 'detalles.sublinea', 'detalles.submercadeo2',
                                  'detalles.tipomarcas', 'detalles.posicionarancelaria', 'detalles.grupoimpositivo',
                                  'eanppal.tembalaje', 'detalles.tipoempaque', 'detalles.condmanipulacion', 'patrones')
                                  ->get();

        $response = compact('proyectos', 'referencias');

        return response()->json($response);
    }

    public function consulta(Request $request){

      return response()->json($request);

    }
}
