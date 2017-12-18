<?php

namespace App\Http\Controllers\controlinversion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TLineas;
use App\Models\Genericas\TCanal;
use App\Models\Aplicativos\User;
use App\Models\controlinversion\TNiveles;
use App\Models\controlinversion\TPerniveles;
use App\Models\controlinversion\TCanalpernivel;
use App\Models\BESA\VendedorZona;


class nivelesAutorizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "Control inversiones // Catalogos // Niveles de autorizacion";
        $titulo = "NIVELES DE AUTORIZACION";
        return view('layouts.controlinversion.nivelesautorizacion.indexnivautorizacion', compact('ruta', 'titulo'));
    }

    public function nivelesAutorizacionGetInfo()
    {
        $terceros = Tercero::with('usuario')->where('indxEstadoTercero', 1)->get();
        $niveles = TNiveles::all();
        $tercerosSinUsuario = [];
        foreach ($terceros as $key => $value) {
            if($value['usuario'] != null){
                array_push($tercerosSinUsuario, $value);
            }
        }
        $terceros = $tercerosSinUsuario;
        $VendedorZona = VendedorZona::select('NitVendedor as idTercero', 'NomVendedor as razonSocialTercero')->where('estado', 1)->get();
        $usuarios = User::all();

        $VendedorConUsuario = [];
        foreach ($VendedorZona as $key => $value) {
            $listObjetEncontr = $usuarios->where('idTerceroUsuario', $value['idTercero'])->all();
            $listObjetEncontr = array_values($listObjetEncontr);
            if (count($listObjetEncontr) > 0) {
                $value->usuario = $listObjetEncontr[0];
                array_push($VendedorConUsuario, $value);
            }
            
        }
        
        $VendedorZona = $VendedorConUsuario;
        $lineas = TLineas::all();
        $canales = TCanal::whereIn('can_id', ['20','AL','DR'])->get();
        $canalPernivel = TCanalpernivel::all();
        $perniveles = TPerniveles::with('children', 'canales')->get();


        $response = compact('terceros', 'niveles', 'VendedorZona', 'lineas', 'canales', 'canalPernivel', 'perniveles', 'usuarios');
        // ['terceros' => [{},{},...n{}], 'niveles' => [{},{},...n{}], 'VendedorZona' => [{},{},...n{}]]
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $persona = new TPerniveles;
        $persona->pern_usuario = $data['selectedItem']['usuario']['login'];
        $persona->pern_nombre = $data['selectedItem']['razonSocialTercero'];
        $persona->pern_cedula = $data['selectedItem']['idTercero'];
        $persona->pern_nomnivel = $data['nivel']['id'];


        if($persona->pern_nomnivel == 4 || $persona->pern_nomnivel == 2){
           $persona->save();
        }

        if($persona->pern_nomnivel == 1){
           $persona->pern_jefe = $data['jefe']['id'];
           $persona->pern_tipopersona = $data['tipo']['id'];
           $persona->save();
        }



        if($persona->pern_nomnivel == 3){
            $persona->pern_jefe = $data['jefe']['id'];
            $persona->save();
            foreach ($data['canales'] as $key => $value) {

                foreach ($data['lineas'] as $clave => $valor) {
                    $canal = new TCanalpernivel;
                    $canal->cap_idcanal = trim($value['can_id']);
                    $canal->cap_idlinea = $valor['lin_id'];
                    $canal->cap_idpernivel = $persona['id'];
                    $canal->save();
                }
            }
        }

        return $persona;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personaNivel = TPerniveles::find($id)->delete();
        return "true";
    }
}
