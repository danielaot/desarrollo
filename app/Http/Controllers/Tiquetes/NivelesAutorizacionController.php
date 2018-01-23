<?php

namespace App\Http\Controllers\Tiquetes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Genericas\TTipopersona as TipoPersona;
use App\Models\Genericas\TCanal as Canal;
use App\Models\Genericas\TTerritoriosNw as Territorios;
use App\Models\Genericas\Tercero as Tercero;
use App\Models\Genericas\TGrupo as Grupo;
use App\Models\Tiquetes\TPernivele as PerNivel;
use App\Models\Tiquetes\TNivele as Niveles;
use App\Models\Genericas\TGerencia as Gerencia;
use App\Models\Tiquetes\TPersona as Persona;
use App\Models\Tiquetes\TCiudad as Ciudades;
use Carbon\Carbon;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

class NivelesAutorizacionController extends Controller
{

    public function index()
    {
        $ruta = 'Tiquetes y Hotel // Niveles de Aprobación';
        $titulo = 'Niveles de Aprobación';
        return view('layouts.tiquetes.nivelesAutorizacion.indexNivelesAutorizacion', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
      $tpersona = TipoPersona::all();
      $canal = Canal::whereIn('can_id',['20','AL','DR','SI'])->get();
      $territorios = Territorios::all();
      $grupo =  Grupo::all();
      $usuarios = Tercero::with('usuario', 'dirnacional')
                        ->where('indxEstadoTercero', 1)
                        ->where('indxEmpleadoTercero', 1)
                        ->get();
      $usuarios = collect($usuarios)->map(function($usuario){
      $usuario['cedulaNombre'] = $usuario['idTercero'].' - '.$usuario['razonSocialTercero'];
      return $usuario;
      });

      $gerencia = Gerencia::all();

      $niveles = Niveles::all();

      $usuariosN = PerNivel::all();
      $usuariosN = collect($usuariosN)->map(function($usuarioN){
      $usuarioN['cedulaNombre'] = $usuarioN['pen_cedula'].' - '.$usuarioN['pen_nombre'];
      return $usuarioN;
      });

      $ciudades = Ciudades::all();

      $response = compact('tpersona', 'canal', 'territorios', 'usuarios', 'grupo', 'niveles', 'usuariosN', 'gerencia', 'ciudades');

      return response()->json($response);
    }

    public function savePerNivel(Request $request)
    {
      if ($request['nivel']['id'] == 1) {

          /*Tabla Perniveles*/
          $perNivel = new PerNivel;
          $perNivel->pen_usuario = $request['usuarioNivel']['usuario']['login'];
          $perNivel->pen_nombre = $request['usuarioNivel']['nombreEstablecimientoTercero'];
          $perNivel->pen_cedula = $request['usuarioNivel']['idTercero'];
          $perNivel->pen_idtipoper = $request['tpersona']['id'];
          $perNivel->pen_nomnivel = 4;
          /*territorios*/
          $territorios = collect($request['territorio']);
          $pluckedTerr = $territorios->pluck('id');
          $pluckedTerr = $pluckedTerr->implode(',');

          $perNivel->pen_idterritorios = $pluckedTerr;
          /*fin territorios*/

          /*CANALES*/
          $canales = collect($request['canal']);

          $canales = $canales->map(function ($canal, $key) {
            $canal['can_id'] = trim($canal['can_id']);
            return $canal;
          });

          $pluckedCanal = $canales->pluck('can_id');
          $pluckedCanal = $pluckedCanal->implode(',');
          $perNivel->pen_idcanales = $pluckedCanal;
          /*fin canales*/
          /*Grupos*/
          $grupos = collect($request['grupo']);
          $pluckedGrupo = $grupos->pluck('gru_sigla');
          $pluckedGrupo = $pluckedGrupo->implode(',');

          $perNivel->pen_idgrupos = $pluckedGrupo;
          $perNivel->save();
          /*fin grupos*/
          /*Fin tabla perniveles*/

          /*Tabla persona*/
          $persona = new Persona;
          $persona->perTxtNivel = 4;
          $persona->perTxtCedtercero = $request['usuarioNivel']['idTercero'];
          $persona->perTxtNomtercero = $request['usuarioNivel']['nombreEstablecimientoTercero'];
          $persona->perTxtFechaNac = strtotime($request['fnacimiento']);
          $persona->perTxtEmailter = $request['usuarioNivel']['dirnacional']['dir_txt_email'];
          $persona->perIntCiudad = $request['ciuexpedicion']['ciuIntId'];
          $persona->perIntTiposolicitud = 0;

          /*territorios*/
          $territorios = collect($request['territorio']);
          $pluckedTerr = $territorios->pluck('id');
          $pluckedTerr = $pluckedTerr->implode(',');

          $persona->perIntIdzona = $pluckedTerr;
          /*fin territorios*/
          /*CANALES*/
          $canales = collect($request['canal']);

          $canales = $canales->map(function ($canal, $key) {
            $canal['can_id'] = trim($canal['can_id']);
            return $canal;
          });

          $pluckedCanal = $canales->pluck('can_id');
          $pluckedCanal = $pluckedCanal->implode(',');
          $persona->perIntIdcanal = $pluckedCanal;
          /*fin canales*/

          $persona->perIntTipopersona = $request['tpersona']['id'];
          $persona->perIntPorcmod = 0;
          $persona->perIntPorcmix = 0;
          $persona->perIntDepencia = 0;
          $persona->perTxtEstado = $request['estado']['value'];
          $persona->perIntTipogerencia = $request['tgerencia']['ger_id'];
          $persona->perTxtNoPasaporte = $request['numpasaporte'];
          $persona->perTxtFechaCadPass = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
          $persona->perIntCiudadExpPass = $request['ciuexpedicion']['ciuIntId'];
          $persona->perIntLifeMiles = $request['lifemiles'];
          $persona->save();
          /*Fin tabla persona*/

      }elseif ($request['nivel']['id'] == 2) {
        //return response()->json($request);
          $perNivel = new PerNivel;
          $perNivel->pen_usuario = $request['usuarioNivel']['usuario']['login'];
          $perNivel->pen_nombre = $request['usuarioNivel']['nombreEstablecimientoTercero'];
          $perNivel->pen_cedula = $request['usuarioNivel']['idTercero'];
          $perNivel->pen_idtipoper = $request['tpersona']['id'];
          $perNivel->pen_nomnivel = $request['nivel']['id'];
          /*territorios*/
          $territorios = collect($request['territorio']);
          $pluckedTerr = $territorios->pluck('id');
          $pluckedTerr = $pluckedTerr->implode(',');

          $perNivel->pen_idterritorios = $pluckedTerr;
          /*fin territorios*/

          /*CANALES*/
          $canales = collect($request['canal']);

          $canales = $canales->map(function ($canal, $key) {
            $canal['can_id'] = trim($canal['can_id']);
            return $canal;
          });

          $pluckedCanal = $canales->pluck('can_id');
          $pluckedCanal = $pluckedCanal->implode(',');
          $perNivel->pen_idcanales = $pluckedCanal;
          /*fin canales*/
          /*Grupos*/
          $grupos = collect($request['grupo']);
          $pluckedGrupo = $grupos->pluck('gru_sigla');
          $pluckedGrupo = $pluckedGrupo->implode(',');

          $perNivel->pen_idgrupos = $pluckedGrupo;
          $perNivel->save();
          /*fin grupos*/
        }
      }



}
