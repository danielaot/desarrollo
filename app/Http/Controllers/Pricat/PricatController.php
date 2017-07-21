<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Uuid;
use Storage;

use App\Models\Pricat\TSolPricat as SolPricat;
use App\Models\Pricat\TCampSegmento as CampSegmento;

class PricatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Pricat // Generar';
        $titulo = 'Generar';

        $solicitadas = SolPricat::with('clientes.terceros')
                                ->where('sop_estado', 'solicitado')
                                ->get();

        $generadas = SolPricat::with('clientes.terceros')
                                ->where('sop_estado', 'creado')
                                ->get();

        $response = compact('ruta', 'titulo', 'solicitadas', 'generadas');

        return view('layouts.pricat.solicitud.indexGenerar', $response);
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
          'solicitud' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return redirect()->back()->withErrors($validator->errors());
        }

        $solicitud = SolPricat::find($request->solicitud);

        if($solicitud->sop_estado == 'creado'){
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

        $solicitud->sop_estado = 'creado';
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
