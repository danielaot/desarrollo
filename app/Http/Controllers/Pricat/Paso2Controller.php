<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;
use DB;

use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\Pricat\TItemEan as IEan;
use App\Models\Pricat\TCriteriosItem as Criterios;
use App\Models\BESA\ItemCriteriosCompletos;
use App\Models\BESA\EANReferencia;
use App\Models\BESA\EANReferenciaEAN14 as EAN14Referencia;

class Paso2Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Confirmación de Creación de Item';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $item =Item::with('detalles.origen','detalles.tipomarcas','detalles.tipooferta','detalles.menuprom',
                           'detalles.tipoprom','detalles.presentacion','detalles.variedad','detalles.categoria',
                           'detalles.linea','detalles.sublinea','detalles.submercadeo','detalles.submercadeo2',
                           'detalles.submarca','detalles.regalias','detalles.segmento','detalles.clasificacion',
                           'detalles.acondicionamiento','detalles.nomtemporada','tipo','eanes')
                    ->where('ite_proy', $request->proy)
                    ->get()->first();

        $componente = ItemCriteriosCompletos::where('referencia', $item->ite_referencia)
                                            ->get()->first();

        $tipo = $item['tipo']['descripcionItemCriterioMayor'];
        $categoria = $item['detalles']['categoria']['descripcionItemCriterioMayor'];
        $comp = $componente->descripcion;
        //return ($comp)

        return view('layouts.pricat.actividades.paso2', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'tipo', 'categoria', 'item'));
    }

    public function update(Request $request, $id)
    {
        $validationRules = [
          'proy' => 'required|numeric',
          'act' => 'required|numeric',
          'item' => 'required|numeric',
          'referencia' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $item = Item::find($id);

        if($item->ite_tproducto == '1301')
          $campo = 'cri_regular';
        if($item->ite_tproducto == '1306')
          $campo = 'cri_estuche';
        if($item->ite_tproducto == '1302')
          $campo = 'cri_oferta';

        $criterios = Criterios::where($campo, 1)
                              ->get();

        $itemdetalle = ItemDetalle::where('ide_item', $id)
                                  ->get()->first();

        $itemunoe = ItemCriteriosCompletos::where('referencia', $request->referencia)
                                          ->get()->first();

        $errores = [];

        if($itemunoe == NULL){
          array_push($errores,'referencia');
        }
        else{
          foreach ($criterios as $key => $value) {
            $colitem = $value->cri_col_item;
            $colunoe = $value->cri_col_unoe;

            if($colunoe != 'cod_tipo_pr'){
              $igual = strtoupper($itemdetalle->$colitem) == strtoupper($itemunoe->$colunoe);
              if(!$igual){
                array_push($errores,$colitem);
              }
            }
          }
        }

        if(count($errores) > 0){
          return response()->json(compact('errores'));
        }
        else{
          $ean13 = EANReferencia::where('Referencia', $request->referencia)
                                ->get()->first();

          $item->ite_ean13 = $ean13->EAN;
          $item->save();

          $ean14 = EAN14Referencia::where('Referencia', $request->referencia)
                                  ->get()->first();

          $itemean = IEan::where('iea_item', $id)
                         ->update(['iea_ean' => $ean14->EAN, 'iea_principal' => 1]);

          DesarrolloCtrl::update($request->proy, $request->act);

          $url = url('pricat/desarrolloactividades');
          return response($url, 200);
        }
    }
}
