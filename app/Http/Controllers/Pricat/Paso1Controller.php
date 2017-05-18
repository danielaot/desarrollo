<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TCategoriasLogyca as CatLogyca;
use App\Models\Genericas\Itemcriterioplan as Planes;
use App\Models\Pricat\TMarca as Marca;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as IDetalle;
use App\Models\Pricat\TItemEan as IEan;

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
        $validationRules = [
          'proy' => 'required',
          'tipo' => 'required',
          'ean' => 'sometimes|required',
          'uso' => 'required',
          'marca' => 'required',
          'varserie' => 'required',
          'contenido' => 'required',
          'contum' => 'required',
          'descorta' => 'required',
          'deslogyca' => 'required',
          'desbesa' => 'required',
          'catlogyca' => 'required',
          'fabricante' => 'required',
          'origen' => 'required',
          'tipomarca' => 'required',
          'presentacion' => 'required',
          'variedadbesa' => 'required',
          'categoria' => 'required',
          'linea' => 'required',
          'sublinea' => 'required',
          'sublinmercadeo' => 'required',
          'sublinmercadeo2' => 'required',
          'submarca' => 'required',
          'embalaje' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json($validator->errors());
        }

        $last_ref = Item::all()->last();

        if(!$last_ref){
          $ref = 'AAA000';
        }
        else{
          $ref = $last_ref->ite_referencia;
          $ref++;
        }

        $item = new Item;
        $item->ite_proy = $request->proy;
        $item->ite_referencia = $ref;
        $item->ite_tproducto = $request->tipo;
        $item->ite_eanext = $request->ean;
        //$item->save();

        $detalle = new IDetalle;
        $detalle->ide_item = $item->id;
        $detalle->ide_uso = $request->uso['id'];
        $detalle->ide_marca = $request->marca['mar_nombre'];
        $detalle->ide_variedad = serialize($request->varserie);
        $detalle->ide_contenido = $request->contenido;
        $detalle->ide_umcont = $request->contum;
        $detalle->ide_descorta = $request->descorta;
        $detalle->ide_deslarga = $request->deslogyca;
        $detalle->ide_descompleta = $request->desbesa;
        $detalle->ide_catlogyca = $request->catlogyca['tcl_codigo'];
        $detalle->ide_nomfab = $request->fabricante;
        $detalle->ide_origen = $request->origen['idItemCriterioMayor'];
        $detalle->ide_tmarca = $request->tipomarca['idItemCriterioMayor'];
        $detalle->ide_toferta = $request->tipooferta['idItemCriterioMayor'];
        $detalle->ide_meprom = $request->menupromo['idItemCriterioMayor'];
        $detalle->ide_tiprom = $request->tipopromo['idItemCriterioMayor'];
        $detalle->ide_presentacion = $request->presentacion['idItemCriterioMayor'];
        $detalle->ide_varbesa = $request->variedadbesa['idItemCriterioMayor'];

        //$detalle->ide_comp1 = $request->ean;
        //$detalle->ide_comp2 = $request->ean;
        //$detalle->ide_comp3 = $request->ean;
        //$detalle->ide_comp4 = $request->ean;

        $detalle->ide_categoria = $request->categoria['cat_id'];
        $detalle->ide_linea = $request->linea['mar_linea'];
        $detalle->ide_sublinea = $request->sublinea['idItemCriterioMayor'];
        $detalle->ide_sublineamer = $request->sublinmercadeo['idItemCriterioMayor'];
        $detalle->ide_sublineamer2 = $request->sublinmercadeo2['idItemCriterioMayor'];
        $detalle->ide_submarca = $request->submarca['idItemCriterioMayor'];
        $detalle->ide_regalias = $request->regalias['idItemCriterioMayor'];
        $detalle->ide_segmento = $request->segmento['idItemCriterioMayor'];
        $detalle->ide_clasificacion = $request->clasificacion['idItemCriterioMayor'];
        $detalle->ide_acondicionamiento = $request->acondicionamiento['idItemCriterioMayor'];
        //$detalle->save();

        $item_ean = new IEan;
        $item_ean->iea_cantemb = $request->embalaje;
        //$item_ean->save();

        //return response()->json([$item,$detalle,$item_ean]);

        $url = url('pricat/desarrolloactividades');
        return response($url, 200);
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
