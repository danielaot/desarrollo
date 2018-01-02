<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Uuid;
use Storage;

use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TSolPricat as SolPricat;
use App\Models\Pricat\TCampSegmento as CampSegmento;
use App\Models\Pricat\TProyecto as Proyecto;

class PricatController extends Controller
{
    public function index()
    {
        $ruta = 'Plataforma Integral de Creación de Items // Pricat // Generar';
        $titulo = 'Generar';

        // $solicitadas = SolPricat::with('clientes.terceros')
        //                         ->where('sop_estado', 'solicitada')
        //                         ->get();
        //
        // $generadas = SolPricat::with('clientes.terceros')
        //                         ->where('sop_estado', 'creada')
        //                         ->get();
        //
        // $items = Item::with('detalles')
        //              ->whereHas('proyectos', function($q){
        //                             $q->where('proy_estado', 'Por Certificar');
        //                         })
        //              ->get();

        $response = compact('ruta', 'titulo');

        return view('layouts.pricat.solicitud.indexGenerar', $response);
    }

    public function getInfo()
    {
        $solicitadas = SolPricat::with('clientes.terceros')
                                ->where('sop_estado', 'solicitada')
                                ->get();

        $generadas = SolPricat::with('clientes.terceros')
                                ->where('sop_estado', 'creada')
                                ->get();

        $items = Item::with('detalles', 'proyectos')
                     ->whereHas('proyectos', function($q){
                                    $q->where('proy_estado', 'Por Certificar');
                                })
                     ->get();

        $response = compact('solicitadas', 'generadas', 'items');

        return response()->json($response);
    }

    public function solicitarPricat (Request $request)
    {
      $item = Item::where('id', $request->pricat)->with('proyectos')->get();

      $itemEst = Item::where('id', $request->pricat)
                  ->update(['ite_est_logyca' => 'Capturado']);

      $proyecto = Proyecto::where('id', $item[0]['ite_proy'])
                          ->update(['proy_estado'=> 'Terminado']);

    }

    public function store(Request $request)
    {
        $validationRules = [
          'solicitud' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return redirect()->back()->withErrors($validator->errors());
        }

        $solicitud = SolPricat::find($request->solicitud);

        if($solicitud->sop_estado == 'creada'){
          $fechahora = Carbon::now();
          $solicitud->sop_fecha_inicio = $fechahora->format('Y-m-d');
          $solicitud->save();
        }

        $solicitud = SolPricat::with('clientes','detalles.items.detalles.logcategorias', 'detalles.items.eanppal', 'detalles.items.detalles.condmanipulacion')
                              ->where('id', $request->solicitud)
                              ->get()->first();

        $encabezado = CampSegmento::where('cse_grupo', 'a')
                                  ->get();

        $txt = $this->replace($encabezado, $solicitud, '');

        $segmentos = CampSegmento::where('cse_tnovedad', $solicitud->sop_tnovedad)
                                 ->whereHas('segmentos', function ($query) use ($solicitud) {
                                                          $query->where('cls_cliente', $solicitud->sop_cliente);
                                          })
                                 ->orderBy('cse_orden')
                                 ->get()
                                 ->groupBy('cse_grupo');

        $cons = 0;
        extract($solicitud->toArray());
        foreach ($solicitud->detalles as $detalle) {
          extract($detalle->toArray());
          extract($items);
          extract($detalles);
          extract($eanppal);
          extract($logcategorias);
          extract($condmanipulacion);

          foreach ($segmentos as $grupo => $info) {
            $cons += 1;
            foreach ($info as $seg) {
              $segmento = $seg->cse_segmento;
              $campo = $seg->cse_campo;
              $lista = explode('&', $segmento);

              for ($i = 0; $i < count($lista); $i++) {
                if($campo != ''){
                  if($lista[$i] == 'var'){
                    if($campo == 'cons')
                      $lista[$i] = $cons;
                    elseif($campo == 'iva')
                      $lista[$i] = $ide_grupoimpositivo == '0021' ? 19 : 0;
                    elseif($campo == 'sop_fecha_inicio' || $campo == 'sop_fecha_fin')
                      $lista[$i] = str_replace('-', '', $$campo);
                    elseif($campo == 'ide_volumen')
                      $lista[$i] = round($$campo/1000,2);
                    else
                      $lista[$i] = $$campo;
                  }
                }
              }

              $segmento = implode('', $lista);
              $txt .= $segmento;
            }
          }
        }

        $cierre = CampSegmento::where('cse_grupo', 'z')
                              ->get();

        $txt = $this->replace($cierre, $solicitud, $txt);

        //return response()->json($txt);

        $filePath = '/public/pricat/solicitudes/';
        $fileName = Uuid::uuid4().'.edi';
        Storage::put($filePath.$fileName,$txt);

        $solicitud->sop_estado = 'creada';
        $solicitud->save();

        return response()->download(storage_path('app'.$filePath.$fileName));
    }

    private function replace($listado, $solicitud, $txt)
    {
        extract($solicitud->toArray());
        $idpricat = str_pad($id, 8, '0', STR_PAD_LEFT);
        extract($clientes);
        $fechahora = Carbon::now();
        $today = $fechahora->format('ymd');
        $today1 = $fechahora->format('Ymd');
        $time = $fechahora->format('Hi');
        $manana = Carbon::tomorrow();
        $tomorrow = $manana->format('Ymd');
        $line = substr_count($txt, "'");

        foreach ($listado as $seg) {
          $segmento = $seg->cse_segmento;
          $campo = $seg->cse_campo;
          $lista = explode('&', $segmento);

          for ($i = 0; $i < count($lista); $i++) {
            if($campo != '' && $lista[$i] == 'var'){
              $lista[$i] = $$campo;
            }
          }

          $segmento = implode('', $lista);
          $txt .= $segmento;
        }

        return $txt;
    }
}
