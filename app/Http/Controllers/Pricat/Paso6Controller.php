<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;

use App\Models\Pricat\TCondManipulacion as CManipulacion;
use App\Models\Pricat\TTipoEmpaque as TEmpaque;
use App\Models\Pricat\TTipoEmbalaje as TEmbalaje;
use App\Models\Pricat\TItem as Item;

class Paso6Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = 'Calidad de Datos y Homologación // Desarrollo de Actividades';
        $titulo = 'Ingreso de Información de Medidas';
        $idproyecto = $request->proy;
        $idactividad = $request->act;

        $item = Item::with('detalles','eanes')
                    ->where('ite_proy', $idproyecto)
                    ->get()->first();

        $lista = DB::connection('besa')
                   ->table('9000-appweb_lista_materiales')
                   ->where(['Cod_Item' => $item->ite_referencia.'P', 'Tipo_Item_Componente' => 'INVPROCEG'])
                   ->get()->first();

        return view('layouts.pricat.actividades.paso6', compact('ruta', 'titulo', 'idproyecto', 'idactividad', 'item'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        $cmanipulacion = CManipulacion::all();
        $tempaque = TEmpaque::all();
        $tembalaje = TEmbalaje::all();

        $response = compact('cmanipulacion', 'tempaque', 'tembalaje');

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
