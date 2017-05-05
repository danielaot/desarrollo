<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TCategoriasLogyca as CatLogyca;
use App\Models\Genericas\Itemcriterioplan as Planes;
use App\Models\Pricat\TMarca as Marca;

class Paso1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Solicitud Creación Item';

        $idproyecto = $request->id;

        return view('layouts.pricat.actividades.paso1', compact('ruta', 'titulo', 'idproyecto'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $vocabas = Vocabas::all();
        $catlogyca = CatLogyca::all();
        $planes = Planes::with('criterios')->get();
        $marca = Marca::distinct()->orderBy('mar_nombre')->get(['mar_nombre']);
        $linea = Marca::with(['lineas.categorias.categorias', 'lineas' => function ($query) {
                                 $query->where('notaItemCriterioMayor', 'Linea Activa');
                             }])
                      ->get();

        foreach ($planes as $plan) {
          $criterios = array_sort_recursive($plan->criterios->toarray());
          switch ($plan->idCriterioPlan) {
            case '100':
                $origen = $criterios;
              break;
            case '129':
                $criterios = collect($criterios);
                $criterios->pop();
                $tipomarca = $criterios->all();
              break;
            case '131':
                $tipooferta = $criterios;
              break;
            case '132':
                $menupromociones = $criterios;
              break;
            case '140':
                $tipopromocion = $criterios;
              break;
            case '141':
                $presentacion = $criterios;
              break;
            case '142':
                $variedad = $criterios;
              break;
            case '200':
                $categoria = $criterios;
              break;
            case '400':
                $sublinea = $criterios;
              break;
            case '405':
                $sublinmercadeo = $criterios;
              break;
            case '406':
                $sublinmercadeo2 = $criterios;
              break;
            case '409':
                $submarca = $criterios;
              break;
            case '420':
                $regalias = $criterios;
              break;
            case '500':
                $segmento = $criterios;
              break;
            case '600':
                $clasificacion = $criterios;
              break;
            case '610':
                $acondicionamiento = $criterios;
              break;
          }
        }

        $referencia = 'AAA000';

        $response = compact('vocabas', 'catlogyca', 'marca', 'origen', 'tipomarca', 'tipooferta', 'menupromociones', 'tipopromocion', 'variedad', 'presentacion', 'categoria', 'linea', 'sublinea', 'sublinmercadeo', 'sublinmercadeo2', 'submarca', 'regalias', 'segmento', 'clasificacion', 'acondicionamiento', 'referencia');

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
        //
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
        //
    }
}
