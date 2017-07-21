<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;
use Carbon\Carbon;
use Uuid;

use App\Models\Pricat\TNotificacionSanitaria as NotSanitaria;
use App\Models\Pricat\TRegsanGranel as RegGranel;
use App\Models\Genericas\TItemCriterio as ItemCriterio;

class NotificacionSanitariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Notificación Sanitaria';
        $titulo = 'Notificación Sanitaria';

        return view('layouts.pricat.notificacionsanitaria.indexNotificacionesSanitarias', compact('ruta', 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $notificaciones = NotSanitaria::with('graneles')->get();
        $graneles = ItemCriterio::where('ite_num_tipoinventario', 1062)->get();

        $response = compact('notificaciones', 'graneles');

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
          'nosa_nombre' => 'required',
          'nosa_notificacion' => 'required',
          'nosa_fecha_inicio' => 'required',
          'nosa_fecha_vencimiento' => 'required',
          'documento' => 'required|file'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        if ($request->hasFile('documento')){
          $filePath = '/public/pricat/registrosanitario/';
          $file = $request->file('documento');
          $fileName = Uuid::uuid4().'.'.$file->getClientOriginalExtension();
          $file->storePubliclyAs($filePath, $fileName);

          $notificacion = new NotSanitaria;
          $notificacion->nosa_nombre = $request->nosa_nombre;
          $notificacion->nosa_notificacion = $request->nosa_notificacion;
          $notificacion->nosa_fecha_inicio = Carbon::createFromFormat('D M d Y', $request->nosa_fecha_inicio)->toDateString();
          $notificacion->nosa_fecha_vencimiento = Carbon::createFromFormat('D M d Y', $request->nosa_fecha_vencimiento)->toDateString();
          $notificacion->nosa_documento = $filePath.$fileName;
          $notificacion->save();

          foreach ($request->notigraneles as $granel){
            $notgranel = new RegGranel;
            $notgranel->rsg_not_san = $notificacion->id;
            $notgranel->rsg_ref_granel = $granel;
            $notgranel->save();
          }
        }

        return response()->json($notificacion);
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
        $validationRules = [
          'nosa_nombre' => 'required',
          'nosa_notificacion' => 'required',
          'nosa_fecha_inicio' => 'required',
          'nosa_fecha_vencimiento' => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()){
          return response()->json(['errors' => $validator->errors()]);
        }

        $notificacion = NotSanitaria::find($request->id);

        if ($request->hasFile('documento')){
          if(Storage::exists($notificacion->nosa_documento)){
            Storage::delete($notificacion->nosa_documento);
          }

          $file = $request->file('documento');
          $fileName = Uuid::uuid4().'.'.$file->getClientOriginalExtension();
          $filePath = '/public/pricat/registrosanitario/';
          $file->storePubliclyAs($filePath, $fileName);

          $notificacion->nosa_documento = $filePath.$fileName;
        }
        
        $notificacion->nosa_nombre = $request->nosa_nombre;
        $notificacion->nosa_notificacion = $request->nosa_notificacion;
        $notificacion->nosa_fecha_inicio = Carbon::createFromFormat('D M d Y', $request->nosa_fecha_inicio)->toDateString();
        $notificacion->nosa_fecha_vencimiento = Carbon::createFromFormat('D M d Y', $request->nosa_fecha_vencimiento)->toDateString();
        $notificacion->save();

        RegGranel::where('rsg_not_san', $request->id)->delete();

        foreach ($request->notigraneles as $granel){
          $notgranel = new RegGranel;
          $notgranel->rsg_not_san = $request->id;
          $notgranel->rsg_ref_granel = $granel;
          $notgranel->save();
        }

        return response()->json($notificacion);
    }
}
