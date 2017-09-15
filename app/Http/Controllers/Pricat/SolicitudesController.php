<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Auth;

use App\Models\Genericas\Item as ItemERP;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TCliente as Cliente;
use App\Models\Pricat\TSolPricat as SolPricat;
use App\Models\Pricat\TSolPricatDetalle as SolPricatDetalle;

class SolicitudesController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Pricat // Mis Solicitudes';
        $titulo = 'Mis Solicitudes';

        $solicitudes = SolPricat::with('clientes.terceros')
                                ->get();

        $response = compact('ruta', 'titulo', 'solicitudes');

        return view('layouts.pricat.solicitud.indexSolicitudes', $response);
    }

    public function getInfo()
    {
        $solicitudes = SolPricat::with('detalles.items.detalles')
                                ->where('sop_kam', Auth::user()->idTerceroUsuario)
                                ->get();

        $response = compact('solicitudes');

        return response()->json($response);
    }

    public function create()
    {
        $ruta = 'Calidad de Datos y Homologación // Pricat // Crear Solicitud';
        $titulo = 'Crear Solicitud';

        $response = compact('ruta', 'titulo');

        return view('layouts.pricat.solicitud.createSolicitud', $response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreateInfo()
    {
        $cliente = Cliente::where(['cli_kam' => Auth::user()->idTerceroUsuario, 'cli_nit' => '900626402'])
                          ->get()->count();

        if($cliente > 0){
          $itemslogyca = Item::with('detalles')
                             ->whereHas('proyectos', function($q){
                                            $q->where('proy_estado', 'Terminado');
                                      })
                             ->get();
        }
        else{
          $itemslogyca = Item::with('detalles')
                             ->whereHas('proyectos', function($q){
                                            $q->where('proy_estado', 'Terminado');
                                      })
                             ->where('ite_est_logyca','<>','No Capturado')
                             ->get();
        }

        $itemserp = ItemERP::all();

        $response = compact('itemserp', 'itemslogyca');

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
          'tnovedad' => 'required',
          'referencias' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $cliente = Cliente::where(['cli_kam' => Auth::user()->idTerceroUsuario])
                          ->get()->first();

        $solicitud = new SolPricat;
        $solicitud->sop_cliente = $cliente->id;
        $solicitud->sop_kam = $cliente->cli_kam;
        $solicitud->sop_tnovedad = $request->tnovedad;
        $solicitud->sop_fecha_inicio = Carbon::createFromFormat('D M d Y', $request->inicio)->toDateString();
        $solicitud->sop_fecha_fin = Carbon::createFromFormat('D M d Y', $request->fin)->toDateString();
        $solicitud->save();

        foreach ($request->referencias as $referencia){
          $detalle = new SolPricatDetalle;
          $detalle->spd_sol = $solicitud->id;
          $detalle->spd_referencia = $referencia['ref']['ite_referencia'];
          $detalle->spd_preciobruto = $referencia['prebru'];
          $detalle->spd_preciosugerido = $referencia['presug'];
          $detalle->save();
        }

        $url = url('pricat/solicitud');
        return response($url, 200);
    }
}
