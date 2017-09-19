<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use Validator;

use App\Models\Pricat\TVocabas as Vocabas;
use App\Models\Pricat\TMarca as Marca;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\Pricat\TNotificacionSanitaria as NotiSanitaria;
use App\Models\BESA\AppwebListaMateriales as ListaMateriales;

class Paso8Controller extends Controller
{
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Confirmación de registro sanitario y su vigencia';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $item = Item::with('detalles')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        $componente = ItemDetalle::where('ide_item', $item->id)
                                  ->get()->first();

        if ($item->ite_tproducto == '1301') {

            $lista = ListaMateriales::where(['Cod_Item' => $item->ite_referencia.'P', 'Tipo_Item_Componente' => 'INVPROCEG', 'metodo' => '0001'])
            ->get()->first();

            $registro = NotiSanitaria::whereHas('graneles', function($query) use($lista){
              $query->where('rsg_ref_granel', trim($lista->Cod_Item_Componente));
            })
            ->get()->first();
        }else {

            $lista = ListaMateriales::where(['Cod_Item' => $componente->ide_comp1.'P', 'Tipo_Item_Componente' => 'INVPROCEG', 'metodo' => '0001'])
            ->get()->first();

            $registro = NotiSanitaria::whereHas('graneles', function($query) use($lista){
              $query->where('rsg_ref_granel', trim($lista->Cod_Item_Componente));
            })
            ->get()->first();
        }

        $response = compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'item', 'registro', 'componente', 'lista');

        return view('layouts.pricat.actividades.paso8', $response);
    }

    public function update(Request $request, $id)
    {
        $validationRules = [
          'proy' => 'required|numeric',
          'act' => 'required|numeric',
          'registro' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
          return response()->json(['errores' => $validator->errors()]);
        }

        ItemDetalle::where('ide_item', $id)
                   ->update(['ide_regsan' => $request->registro['id']]);

        DesarrolloCtrl::update($request->proy, $request->act);

        $url = url('pricat/desarrolloactividades');
        return response($request->all(), 200);
    }
}
