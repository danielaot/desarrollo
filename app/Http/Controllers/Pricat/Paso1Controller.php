<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TCategoriasLogyca as CatLogyca;
use App\Models\Genericas\Itemcriterioplan as Planes;
use App\Models\Genericas\Itemcriteriomayor as Criterio;
use App\Models\Genericas\TItemCriterio as ItemCriterio;
use App\Models\Pricat\TMarca as Marca;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as IDetalle;
use App\Models\Pricat\TItemEan as IEan;
use App\Models\Pricat\TPredecesora as ActPre;
use App\Models\Pricat\TDesarrolloActividad as DesAct;

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

        $idproyecto = $request->proy;
        $idactividad = $request->act;

        return view('layouts.pricat.actividades.paso1', compact('ruta', 'titulo', 'idproyecto', 'idactividad'));
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

        $items = ItemCriterio::where('ite_num_tipoinventario', 1051)
                             ->whereIn('ite_num_estado', [1201, 1202, 1207])
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

        $response = compact('vocabas', 'catlogyca', 'marca', 'origen', 'tipomarca', 'tipooferta', 'menupromociones', 'tipopromocion', 'variedad', 'presentacion', 'categoria', 'linea', 'sublinea', 'sublinmercadeo', 'sublinmercadeo2', 'submarca', 'regalias', 'segmento', 'clasificacion', 'acondicionamiento', 'referencia', 'items');

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

        $tipo_producto = $request->tipo != 'Oferta' ? $request->tipo : 'Promocion';

        $tipo = Criterio::where(['idItemCriterioPlanItemCriterioMayor' => 130, 'descripcionItemCriterioMayor' => $tipo_producto])
                        ->get()
                        ->first();

        $item = new Item;
        $item->ite_proy = $request->proy;
        $item->ite_referencia = $ref;
        $item->ite_tproducto = $tipo['idItemCriterioMayor'];
        $item->ite_eanext = $request->ean;
        $item->save();

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
        $detalle->ide_comp1 = $request->comp1['ite_txt_referencia'];
        $detalle->ide_comp2 = $request->comp2['ite_txt_referencia'];
        $detalle->ide_comp3 = $request->comp3['ite_txt_referencia'];
        $detalle->ide_comp4 = $request->comp4['ite_txt_referencia'];
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
        $detalle->save();

        $item_ean = new IEan;
        $item_ean->iea_item = $item->id;
        $item_ean->iea_cantemb = $request->embalaje;
        $item_ean->save();

        $fecha = Carbon::now();

        $desarrollo = DesAct::where(['dac_proy_id' => $request->proy, 'dac_act_id' => $request->act])
                            ->update(['dac_fecha_cumplimiento' => $fecha,'dac_estado' => 'Completado']);

        $actdespues = ActPre::where('pre_act_pre_id', $request->act)->get();

        foreach($actdespues as $actividad){
          DesAct::where(['dac_proy_id' => $request->proy, 'dac_act_id' => $actividad->pre_act_id])
                ->update(['dac_fecha_inicio' => $fecha,'dac_estado' => 'En Proceso']);
        }

        $url = url('pricat/desarrolloactividades');
        return response($url, 200);
    }
}
