<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;
use DB;

use App\Models\Pricat\TCondManipulacion as CManipulacion;
use App\Models\Pricat\TTipoEmpaque as TEmpaque;
use App\Models\Pricat\TTipoEmbalaje as TEmbalaje;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\Pricat\TItemEan as ItemEan;
use App\Models\Pricat\TItemPatron as ItemPatron;
use App\Models\BESA\AppwebListaMateriales as ListaMateriales;
use App\Models\Desarrollo\TFormulamaestra as FormulaMaestra;

class Paso6Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Ingreso de Información de Medidas';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $item = Item::with('detalles','eanes')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        $descorta = str_replace($item->detalles->ide_contenido.$item->detalles->ide_umcont, '', $item->detalles->ide_descorta);
        $deslarga = str_replace($item->detalles->ide_contenido.$item->detalles->ide_umcont, '', $item->detalles->ide_deslarga);

        $pesoneto = 0;

        if($item->ite_tproducto == '1301'){
          $lista = ListaMateriales::where(['Cod_Item' => $item->ite_referencia.'P', 'Tipo_Item_Componente' => 'INVPROCEG', 'metodo' => '0001'])
                                  ->get()->first();

          $formula = FormulaMaestra::where('frm_txt_codigounoe', trim($lista->Cod_Item_Componente))
                                   ->get()->first();

          $densidad = $formula->frm_txt_densidad;

          $pesoneto = $item->detalles['ide_contenido'] * $densidad/1000;
        }

        $response = compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'item', 'descorta', 'deslarga', 'pesoneto');

        return view('layouts.pricat.actividades.paso6', $response);
    }

    public function getInfo()
    {
        $cmanipulacion = CManipulacion::orderBy('tcman_nombre')->get();
        $tempaque = TEmpaque::orderBy('temp_nombre')->get();
        $tembalaje = TEmbalaje::all();

        $response = compact('cmanipulacion', 'tempaque', 'tembalaje');

        return response()->json($response);
    }

    public function upload(Request $request)
    {
        /*$filePath = '/public/pricat/items/';
        $file = $request->file('file');
        $fileName = Uuid::uuid4().'.'.$file->getClientOriginalExtension();
        $file->storePubliclyAs($filePath, $fileName);
        return response()->json($fileName);
        if ($request->hasFile('file')){
        }

        return response()->json($request->all());*/
    }

    public function update(Request $request)
    {
        $validationRules = [
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

        /*if ($request->hasFile('imagen')){
          $filePath = '/public/pricat/items/';
          $file = $request->file('imagen');
          $fileName = $producto['ref'].'-'.Uuid::uuid4().'.'.$file->getClientOriginalExtension();
          $file->storePubliclyAs($filePath, $fileName);
          return response()->json($fileName);
        }*/

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
        return response($url, 200);
    }
}
