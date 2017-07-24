<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TMarca as Marca;
use App\Models\Pricat\TItem as Item;

class Paso7Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Confirmación de descripciones';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $item = Item::with('detalles','eanes')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        $response = compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'item');

        return view('layouts.pricat.actividades.paso7', $response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo(Request $request)
    {
        $vocabas = Vocabas::all();
        $marca = Marca::distinct()->orderBy('mar_nombre')->get(['mar_nombre']);

        $response = compact('vocabas', 'marca');

        return response()->json($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /*$validationRules = [
          'producto.proy' => 'required|numeric',
          'producto.act' => 'required|numeric',
          'producto.item' => 'required|numeric',
          'producto' => 'required',
          'empaque' => 'required',
          'patron' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
        }

        $producto = $request->producto;
        $empaque = $request->empaque;
        $patron = $request->patron;

        $itemdet = ItemDetalle::where('ide_item', $producto['item'])
                              ->get()->first();

        $itemdet->ide_alto = $producto['alto'];
        $itemdet->ide_ancho = $producto['ancho'];
        $itemdet->ide_profundo = $producto['profundo'];
        $itemdet->ide_volumen = $producto['alto']*$producto['ancho']*$producto['profundo'];
        $itemdet->ide_pesobruto = $producto['pesobruto'];
        $itemdet->ide_pesoneto = $producto['pesoneto'];
        $itemdet->ide_tara = $producto['pesobruto']-$producto['pesoneto'];
        $itemdet->ide_temp = $producto['tempaque'];
        $itemdet->ide_condman = $producto['manipulacion'];
        $itemdet->save();

        $descorta = str_replace($itemdet->ide_contenido.$itemdet->ide_umcont, '', $itemdet->ide_descorta);
        $deslarga = str_replace($itemdet->ide_contenido.$itemdet->ide_umcont, '', $itemdet->ide_deslarga);

        $ieanppal = ItemEan::where(['iea_item' => $producto['item'], 'iea_principal' => 1])
                           ->get()->first();

        $ieanppal->iea_cantemb = $producto['cantemb'];
        $ieanppal->iea_temb = $producto['tembalaje'];
        $ieanppal->iea_descorta = $descorta.$producto['cantemb'].'art';
        $ieanppal->iea_deslarga = $deslarga.$producto['cantemb'].'art';
        $ieanppal->iea_alto = $empaque['alto'];
        $ieanppal->iea_ancho = $empaque['ancho'];
        $ieanppal->iea_profundo = $empaque['profundo'];
        $ieanppal->iea_volumen = $empaque['alto']*$empaque['ancho']*$empaque['profundo'];
        $ieanppal->iea_pesobruto = $empaque['pesobruto'];
        $ieanppal->iea_pesoneto = $producto['pesoneto']*$producto['cantemb'];
        $ieanppal->iea_tara = $empaque['pesobruto']-($producto['pesoneto']*$producto['cantemb']);
        $ieanppal->save();

        $itempat = new ItemPatron;
        $itempat->ipa_item = $producto['item'];
        $itempat->ipa_numtendidos = $patron['numtendidos'];
        $itempat->ipa_cajten = $patron['cajten'];
        $itempat->ipa_tenest = $patron['tenest'];
        $itempat->ipa_undten = $producto['cantemb']*$patron['cajten'];
        $itempat->ipa_undest = $producto['cantemb']*$patron['cajten']*$patron['tenest'];
        $itempat->ipa_caest = $patron['cajten']*$patron['tenest'];
        $itempat->save();

        DesarrolloCtrl::update($producto['proy'], $producto['act']);

        $url = url('pricat/desarrolloactividades');
        return response($url, 200);*/
    }
}
