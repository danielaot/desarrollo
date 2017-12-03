<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;
use Carbon\Carbon;
use Auth;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TCategoriasLogyca as CatLogyca;
use App\Models\Genericas\Itemcriterioplan as Planes;
use App\Models\Genericas\Itemcriteriomayor as Criterio;
use App\Models\Genericas\TItemCriterio as ItemCriterio;
use App\Models\Pricat\TMarca as Marca;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\Pricat\TItemEan as IEan;
ini_set('memory_limit', '-1');

class Paso1Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Solicitud Creación Item';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $last_ref = Item::all()->last();

        if(!$last_ref){
          $referencia = 'AAA000';
        }
        else{
          $referencia = $last_ref->ite_referencia;
          $referencia++;
        }

        return view('layouts.pricat.actividades.paso1', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'referencia'));
    }

    public function getInfo()
    {
        $vocabas = Vocabas::all();
        $catlogyca = CatLogyca::all();
        $planes = Planes::with('criterios')->get();
        $marcas = Marca::distinct()->orderBy('mar_nombre')->get(['mar_nombre']);
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
            case '110':
                $clase = $criterios;
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
            case '953':
                $nomtemporada = $criterios;
              break;
            case '120':
                $estadoref = $criterios;
              break;
          }
        }

        $response = compact('vocabas', 'catlogyca', 'marcas', 'origen', 'clase', 'tipomarca', 'tipooferta', 'menupromociones', 'tipopromocion', 'variedad', 'presentacion', 'categoria', 'linea', 'sublinea', 'sublinmercadeo', 'sublinmercadeo2', 'submarca', 'regalias', 'segmento' , 'clasificacion' , 'acondicionamiento', 'nomtemporada', 'estadoref', 'items', 'itemdet');

        return response()->json($response);
    }

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
          'embalaje' => 'required',
          'estadoref' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $last_ref = Item::all()->last();

        if(!$last_ref){
          $ref = 'AAA000';
        }
        else{
          $ref = $last_ref->ite_referencia;
          $ref++;
        }

        switch ($request->tipo) {
          case 'Regular':
              $tipo_producto = $request->tipo;
            break;
          case 'Oft.':
              $tipo_producto = 'Promocion';
            break;
          case 'Etch.':
              $tipo_producto = 'Estuche';
            break;
        }

        $tipo = Criterio::where(['idItemCriterioPlanItemCriterioMayor' => 130, 'descripcionItemCriterioMayor' => $tipo_producto])
                        ->get()->first();

        $item = new Item;
        $item->ite_proy = $request->proy;
        $item->ite_referencia = $ref;
        $item->ite_tproducto = $tipo['idItemCriterioMayor'];
        $item->ite_eanext = $request->ean;
        $item->ite_dat_captura = Carbon::createFromFormat('D M d Y', $request->captura)->toDateString();
        $item->save();

        $detalle = new ItemDetalle;
        $detalle->ide_item = $item->id;
        $detalle->ide_estadoref = $request->estadoref['idItemCriterioMayor'];
        $detalle->ide_uso = $request->uso['id'];
        $detalle->ide_marca = $request->marca['mar_nombre'];
        $detalle->ide_variedad = $request->varserie;
        $detalle->ide_contenido = $request->contenido;
        $detalle->ide_umcont = $request->contum;
        $detalle->ide_descorta = $request->descorta;
        $detalle->ide_deslarga = $request->deslogyca;
        $detalle->ide_descompleta = $request->desbesa;
        $detalle->ide_catlogyca = $request->catlogyca['id'];
        $detalle->ide_nomfab = $request->fabricante;
        $detalle->ide_origen = $request->origen['idItemCriterioMayor'];
        $detalle->ide_clase = $request->clase['idItemCriterioMayor'];
        $detalle->ide_tmarca = $request->tipomarca['idItemCriterioMayor'];
        $detalle->ide_presentacion = $request->presentacion['idItemCriterioMayor'];
        $detalle->ide_varbesa = $request->variedadbesa['idItemCriterioMayor'];
        $detalle->ide_categoria = $request->categoria['cat_id'];
        $detalle->ide_linea = $request->linea['mar_linea'];
        $detalle->ide_sublinea = $request->sublinea['idItemCriterioMayor'];
        $detalle->ide_sublineamer = $request->sublinmercadeo['idItemCriterioMayor'];
        $detalle->ide_sublineamer2 = $request->sublinmercadeo2['idItemCriterioMayor'];
        $detalle->ide_submarca = $request->submarca['idItemCriterioMayor'];
        $detalle->ide_regalias = $request->regalias['idItemCriterioMayor'];
        $detalle->ide_toferta = $request->tipooferta ? $request->tipooferta['idItemCriterioMayor'] : 'noap';
        $detalle->ide_meprom = $request->menupromo ? $request->menupromo['idItemCriterioMayor'] : 'noap';
        $detalle->ide_tiprom = $request->tipopromo ? $request->tipopromo['idItemCriterioMayor'] : 'noap';
        $detalle->ide_comp1 = $request->comp1 ? $request->comp1['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_comp2 = $request->comp2 ? $request->comp2['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_comp3 = $request->comp3 ? $request->comp3['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_comp4 = $request->comp4 ? $request->comp4['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_comp5 = $request->comp5 ? $request->comp5['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_comp6 = $request->comp6 ? $request->comp6['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_comp7 = $request->comp7 ? $request->comp7['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_comp8 = $request->comp8 ? $request->comp8['ite_txt_referencia'] : 'No Catalogado';
        $detalle->ide_segmento = $request->segmento ? $request->segmento['idItemCriterioMayor'] : 'noap';
        $detalle->ide_clasificacion = $request->clasificacion ? $request->clasificacion['idItemCriterioMayor'] : 'noap';
        $detalle->ide_acondicionamiento = $request->acondicionamiento ? $request->acondicionamiento['idItemCriterioMayor'] : 'noap';
        $detalle->ide_nomtemporada = $request->nomtemporada ? $request->nomtemporada['idItemCriterioMayor'] : 'noap';
        $detalle->ide_anotemporada = $request->anotemporada ? $request->anotemporada : 'No Catalogado';
        //return response()->json($request->all());
        $detalle->save();

        $item_ean = new IEan;
        $item_ean->iea_item = $item->id;
        $item_ean->iea_cantemb = $request->embalaje;
        $item_ean->save();

        $update = DesarrolloCtrl::update($request->proy, $request->act);

        $url = url('pricat/desarrolloactividades');

        return response($url, 200);

        // $response = compact('update', 'url');

        return response($url, 200);
    }

    public function edit(Request $request, $proy){

      $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
      $titulo = 'Editar Item';
      $idproyecto = $proy;
      $idactividad = $request->act;

      $item = Item::where('ite_proy', $idproyecto)->with('tipo')
                        ->get();

      $idItem = $item[0]['id'];
      $ref = $item[0]['ite_referencia'];


      $itemdet = ItemDetalle::with('estadoref','uso', 'logcategorias', 'origen', 'tipomarcas', 'variedad', 'linea',
                                   'submercadeo', 'sublinea', 'submarca', 'clase', 'presentacion', 'menuprom',
                                   'submercadeo2', 'regalias', 'itemean', 'items', 'tipoprom', 'tipooferta',
                                   'items.tipo', 'comp1', 'comp2', 'comp3', 'comp4', 'comp5', 'comp6', 'comp7', 'comp8',
                                   'nomtemporada')
                                   ->where('ide_item', $idItem)->get();

      return view('layouts.pricat.actividades.paso1edit', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'ref', 'itemdet'));
    }

    public function editProducto (Request $request){
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
         return response()->json(['errors' => $validator->errors()]);
       }

       $last_ref = Item::all()->last();
       $ref = $last_ref->ite_referencia;

       switch ($request->tipo) {
         case 'Regular':
             $tipo_producto = $request->tipo;
           break;
         case 'Oft.':
             $tipo_producto = 'Promocion';
           break;
         case 'Etch.':
             $tipo_producto = 'Estuche';
           break;
       }
       $tipo = Criterio::where(['idItemCriterioPlanItemCriterioMayor' => 130, 'descripcionItemCriterioMayor' => $tipo_producto])
                       ->get()->first();

       $ite_dat_captura = Carbon::createFromFormat('D M d Y', $request->captura)->toDateString();

       $item = Item::where('ite_proy', $request->proy)
                   ->update(['ite_referencia' => $ref, 'ite_tproducto' => $tipo['idItemCriterioMayor'], 'ite_eanext' => $request->ean, 'ite_dat_captura' => $ite_dat_captura]);

       $idItem = Item::where('ite_proy', $request->proy)->get();
       $ide_toferta = $request->tipooferta ? $request->tipooferta['idItemCriterioMayor'] : 'noap';
       $ide_meprom = $request->menupromo ? $request->menupromo['idItemCriterioMayor'] : 'noap';
       $ide_tiprom = $request->tipopromo ? $request->tipopromo['idItemCriterioMayor'] : 'noap';
       $ide_comp1 = $request->comp1 ? $request->comp1['ite_txt_referencia'] : 'No Catalogado';
       $ide_comp2 = $request->comp2 ? $request->comp2['ite_txt_referencia'] : 'No Catalogado';
       $ide_comp3 = $request->comp3 ? $request->comp3['ite_txt_referencia'] : 'No Catalogado';
       $ide_comp4 = $request->comp4 ? $request->comp4['ite_txt_referencia'] : 'No Catalogado';
       $ide_comp5 = $request->comp5 ? $request->comp5['ite_txt_referencia'] : 'No Catalogado';
       $ide_comp6 = $request->comp6 ? $request->comp6['ite_txt_referencia'] : 'No Catalogado';
       $ide_comp7 = $request->comp7 ? $request->comp7['ite_txt_referencia'] : 'No Catalogado';
       $ide_comp8 = $request->comp8 ? $request->comp8['ite_txt_referencia'] : 'No Catalogado';
       $ide_segmento = $request->segmento ? $request->segmento['idItemCriterioMayor'] : 'noap';
       $ide_clasificacion = $request->clasificacion ? $request->clasificacion['idItemCriterioMayor'] : 'noap';
       $ide_acondicionamiento = $request->acondicionamiento ? $request->acondicionamiento['idItemCriterioMayor'] : 'noap';
       $ide_nomtemporada = $request->nomtemporada ? $request->nomtemporada['idItemCriterioMayor'] : 'noap';
       $ide_anotemporada = $request->anotemporada ? $request->anotemporada : 'No Catalogado';
       $varserie = $request->varserie;

       $detalle = ItemDetalle::where('ide_item', $idItem[0]['id'])
                             ->update(['ide_uso' => $request->uso['id'], 'ide_marca' => $request->marca['mar_nombre'], 'ide_variedad' => serialize($request->varserie),
                                      'ide_contenido' => $request->contenido,'ide_umcont' => $request->contum, 'ide_descorta' => $request->descorta, 'ide_deslarga' => $request->deslogyca,
                                      'ide_descompleta' => $request->desbesa,'ide_catlogyca' => $request->catlogyca['id'], 'ide_nomfab' => $request->fabricante, 'ide_origen' => $request->origen['idItemCriterioMayor'],
                                      'ide_clase' => $request->clase['idItemCriterioMayor'], 'ide_tmarca' => $request->tipomarca['idItemCriterioMayor'], 'ide_presentacion' => $request->presentacion['idItemCriterioMayor'],
                                      'ide_varbesa' => $request->variedadbesa['idItemCriterioMayor'], 'ide_categoria' => $request->categoria['cat_id'], 'ide_linea' => $request->linea['lineas'][0]['idItemCriterioMayor'],
                                      'ide_sublinea' => $request->sublinea['idItemCriterioMayor'], 'ide_sublineamer' => $request->sublinmercadeo['idItemCriterioMayor'], 'ide_sublineamer2' => $request->sublinmercadeo2['idItemCriterioMayor'],
                                      'ide_submarca' => $request->submarca['idItemCriterioMayor'], 'ide_regalias' => $request->regalias['idItemCriterioMayor'], 'ide_toferta' => $ide_toferta, 'ide_meprom' => $ide_meprom, 'ide_tiprom' => $ide_tiprom,
                                      'ide_comp1' => $ide_comp1, 'ide_comp2' => $ide_comp2, 'ide_comp3' => $ide_comp3, 'ide_comp4' => $ide_comp4, 'ide_comp5' => $ide_comp5, 'ide_comp6' => $ide_comp6, 'ide_comp7' => $ide_comp7, 'ide_comp8' => $ide_comp8,
                                      'ide_segmento' => $ide_segmento, 'ide_clasificacion' => $ide_clasificacion, 'ide_acondicionamiento' => $ide_acondicionamiento, 'ide_nomtemporada' => $ide_nomtemporada, 'ide_anotemporada' => $ide_anotemporada]);

      $item_ean = IEan::where('iea_item', $idItem[0]['id'])
                      ->update(['iea_cantemb' => $request->embalaje]);

       $update = DesarrolloCtrl::update($request->proy, $request->act);

       $url = url('pricat/desarrolloactividades');

       $response = compact('update', 'url');

       return response($url, 200);
    }
}
