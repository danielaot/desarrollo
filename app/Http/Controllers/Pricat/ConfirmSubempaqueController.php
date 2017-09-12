<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pricat\DesarrolloActividadesController as DesarrolloCtrl;
use DB;

use App\Models\Pricat\TSolSubempaque as SolSubempaque;
use App\Models\Pricat\TItemEan as ItemEan;

class ConfirmSubempaqueController extends Controller
{
    public function index(Request $request)
    {
        $solicitud = SolSubempaque::with('items')
                                  ->where('ssu_proy', $request->proy)
                                  ->get()->first();

        $ean14 = DB::connection('besa')
                   ->table('101_Item_EAN')
                   ->where(['Referencia' => $solicitud->items['ite_referencia'], 'CantUndMedida' => $solicitud->ssu_cantemb])
                   ->get()->first();

        if(count($ean14) > 0){
          $ean = new ItemEan;
          $ean->iea_item = $solicitud->ssu_item;
          $ean->iea_ean = $ean14->EAN;
          $ean->iea_cantemb = $solicitud->ssu_cantemb;
          $ean->save();

          $solicitud->ssu_estado = 'creado';
          $solicitud->save();

          /*SolSubempaque::where(['dac_proy_id' => $proy, 'dac_act_id' => $actividad->pre_act_id])
                    ->update(['dac_fecha_inicio' => $fecha, 'dac_estado' => 'En Proceso'])*/

          DesarrolloCtrl::update($request->proy, $request->act);
        }

        return redirect('pricat/desarrolloactividades');
    }
}
