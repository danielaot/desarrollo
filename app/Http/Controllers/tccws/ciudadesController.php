<?php

namespace App\Http\Controllers\tccws;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\tccws\TCiudadestcc;
use App\Models\BESA\AppwebCiudades;

class ciudadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *1
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "SGA // CIUDADES - TCC";
        $titulo = "Ciudades - TCC";
        $response = compact('ruta', 'titulo');
        return view('layouts.tccws.Catalogos.ciudadesCatalogo', $response);
    }
        
    public function getInfo()
    {
        $ciu = TCiudadestcc::all();
        $ciuExcl = $ciu->groupBy('ctc_ciu_erp')->keys()->all();
        $ciuErp = AppwebCiudades::whereNotIn('des_ciudad', $ciuExcl)->get();
        $deptoErp = $ciuErp->groupBy('desc_depto')->keys()->all();
        $infoDane = $ciu->groupBy('ctc_cod_dane')->keys()->all();
        
        $response = compact('ciu', 'ciuErp', 'deptoErp', 'ciuExcl', 'infoDane');
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$data = $request->all();
        $data['ctc_tipo_geo'] = '';
        $data['ctc_cod_sion'] = '';
        $data['ctc_dept_id'] = '';
        $data['ctc_depa_desc'] = $data['ctc_dept_erp'];
        $data['ctc_ciu_tcc'] = $data['ctc_ciu_erp'];
        $data['ctc_ciu_abrv'] = '';
        $data['ctc_pais_d'] = 48;
        $data['ctc_pais_abrv'] = 'COL';
        $data['ctc_ticg_id_int'] = '';
        $data['ctc_ticg_desc'] = '';
        $data['ctc_loca_id_int'] = '';
        $data['ctc_cop'] = '';
        $data['ctc_reex'] = '';
        $data['ctc_estado'] = '';
        $creacion = TCiudadestcc::create($data);
        return response()->json($creacion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $ciudad = TCiudadestcc::find($id);
        $data = $request->all();
        $ciudad->ctc_ciu_erp = $data['ctc_ciu_erp'];
        $ciudad->save();

        return response()->json($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
 
    }

}