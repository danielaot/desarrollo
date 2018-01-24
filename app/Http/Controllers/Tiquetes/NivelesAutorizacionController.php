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
use App\Models\Tiquetes\TPersonaDepende as PerDepende;
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
          $perNivel->pen_usuario = $request['tercero']['usuario']['login'];
          $perNivel->pen_nombre = $request['tercero']['nombreEstablecimientoTercero'];
          $perNivel->pen_cedula = $request['tercero']['idTercero'];
          $perNivel->pen_idtipoper = $request['tpersona']['id'];
          $perNivel->pen_nomnivel = $request['nivel']['id'];
          /*territorios*/
          $territorios = collect($request['territorio']);
          $pluckedTerr = $territorios->pluck('id');
          $pluckedTerr = $pluckedTerr->implode(',');
          $perNivel->pen_idterritorios = $pluckedTerr;
          /*fin territorios*/

          /*CANALES*/
          $canales = collect($request['canales']);
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
          /*fin grupos*/
          $perNivel->pen_nivelpadre = 2;
          $perNivel->save();

          /*Fin tabla perniveles*/

          /*Tabla persona*/
          $persona = new Persona;
          $persona->perTxtNivel = 4;
          $persona->perTxtCedtercero = $request['tercero']['idTercero'];
          $persona->perTxtNomtercero = $request['tercero']['nombreEstablecimientoTercero'];
          $persona->perTxtFechaNac = strtotime($request['fnacimiento']);
          $persona->perTxtEmailter = $request['tercero']['dirnacional']['dir_txt_email'];
          $persona->perIntCiudad = 0;
          $persona->perIntTiposolicitud = 0;

          /*territorios*/
          if ($request['tpersona']['id'] == '1') {
            $persona->perIntIdzona = 0;
          }elseif ($request['tpersona']['id'] == '2') {
            $territorios = collect($request['territorio']);
            $pluckedTerr = $territorios->pluck('id');
            $pluckedTerr = $pluckedTerr->implode(',');
            $persona->perIntIdzona = $pluckedTerr;
          }
          /*fin territorios*/
          /*canales*/
          $canales = collect($request['canales']);
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

          /*Inicio Persona Depende*/
          $perdepende = new PerDepende;
          $perdepende->perdepPerIntId = $persona->perIntId;
          $perdepende->perdepPerIntIdAprueba = 0;
          /*canales*/
          if ($request['tpersona']['id'] == '1' || $request['tpersona']['id'] == '2') {
                $canales = collect($request['canales']);
                $canales = $canales->map(function ($canal, $key) {
                  $canal['can_id'] = trim($canal['can_id']);
                  return $canal;
                });
                $pluckedCanal = $canales->pluck('can_id');
                $pluckedCanal = $pluckedCanal->implode(',');
                $perdepende->perdepIntCanal = $pluckedCanal;
          }elseif ($request['tpersona']['id'] == '3' || $request['tpersona']['id'] == '4' || $request['tpersona']['id'] == '5') {
                $perdepende->perdepIntCanal = 0;
          }
          /*fin canales*/
          /*territorios*/
          if ($request['tpersona']['id'] == '1' || $request['tpersona']['id'] == '3' || $request['tpersona']['id'] == '4' || $request['tpersona']['id'] == '5') {
            $perdepende->perdepIntTerritorio = 0;
          }elseif ($request['tpersona']['id'] == '2') {
            $territorios = collect($request['territorio']);
            $pluckedTerr = $territorios->pluck('id');
            $pluckedTerr = $pluckedTerr->implode(',');
            $perdepende->perdepIntTerritorio = $pluckedTerr;
          }
          /*fin territorios*/
          /*Grupos*/
          if ($request['tpersona']['id'] == '1' || $request['tpersona']['id'] == '2' || $request['tpersona']['id'] == '5') {
              $perdepende->perdepIntGrupo = 0;
          }elseif ($request['tpersona']['id'] == '2' || $request['tpersona']['id'] == '3' ) {
            $grupos = collect($request['grupo']);
            $pluckedGrupo = $grupos->pluck('gru_sigla');
            $pluckedGrupo = $pluckedGrupo->implode(',');

            $perdepende->perdepIntGrupo = $pluckedGrupo;
          }
          /*fin grupos*/
          $perdepende->perdepIntPorcentaje = 0;
          $perdepende->save();
          return response()->json($perdepende);
          /*Fin Persona Depende*/

      }
      // elseif ($request['nivel']['id'] == 2) {
      //   return response()->json($request);
      //   /*Tabla Perniveles*/
      //   $perNivel = new PerNivel;
      //   $perNivel->pen_usuario = $request['tercero']['usuario']['login'];
      //   $perNivel->pen_nombre = $request['tercero']['nombreEstablecimientoTercero'];
      //   $perNivel->pen_cedula = $request['tercero']['idTercero'];
      //   $perNivel->pen_idtipoper = $request['tpersona']['id'];
      //   $perNivel->pen_nomnivel = $request['nivel']['id'];
      //   /*territorios*/
      //   $territorios = collect($request['territorio']);
      //   $pluckedTerr = $territorios->pluck('id');
      //   $pluckedTerr = $pluckedTerr->implode(',');
      //   $perNivel->pen_idterritorios = $pluckedTerr;
      //   /*fin territorios*/
      //
      //   /*CANALES*/
      //   $canales = collect($request['canales']);
      //   $canales = $canales->map(function ($canal, $key) {
      //     $canal['can_id'] = trim($canal['can_id']);
      //     return $canal;
      //   });
      //   $pluckedCanal = $canales->pluck('can_id');
      //   $pluckedCanal = $pluckedCanal->implode(',');
      //   $perNivel->pen_idcanales = $pluckedCanal;
      //   /*fin canales*/
      //
      //   /*Grupos*/
      //   $grupos = collect($request['grupo']);
      //   $pluckedGrupo = $grupos->pluck('gru_sigla');
      //   $pluckedGrupo = $pluckedGrupo->implode(',');
      //   $perNivel->pen_idgrupos = $pluckedGrupo;
      //   /*fin grupos*/
      //   $perNivel->pen_nivelpadre = 3;
      //   $perNivel->save();
      //
      //   /*Fin tabla perniveles*/
      //
      //   /*Tabla persona*/
      //   $persona = new Persona;
      //   $persona->perTxtNivel = 3;
      //   $persona->perTxtCedtercero = $request['tercero']['idTercero'];
      //   $persona->perTxtNomtercero = $request['tercero']['nombreEstablecimientoTercero'];
      //   $persona->perTxtFechaNac = strtotime($request['fnacimiento']);
      //   $persona->perTxtEmailter = $request['tercero']['dirnacional']['dir_txt_email'];
      //   $persona->perIntCiudad = 0;
      //   $persona->perIntTiposolicitud = 0;
      //
      //   /*territorios*/
      //   if ($request['tpersona']['id'] == '1') {
      //     $persona->perIntIdzona = 0;
      //   }elseif ($request['tpersona']['id'] == '2') {
      //     $territorios = collect($request['territorio']);
      //     $pluckedTerr = $territorios->pluck('id');
      //     $pluckedTerr = $pluckedTerr->implode(',');
      //     $persona->perIntIdzona = $pluckedTerr;
      //   }
      //   /*fin territorios*/
      //   /*canales*/
      //   $canales = collect($request['canales']);
      //   $canales = $canales->map(function ($canal, $key) {
      //     $canal['can_id'] = trim($canal['can_id']);
      //     return $canal;
      //   });
      //   $pluckedCanal = $canales->pluck('can_id');
      //   $pluckedCanal = $pluckedCanal->implode(',');
      //   $persona->perIntIdcanal = $pluckedCanal;
      //   /*fin canales*/
      //
      //   $persona->perIntTipopersona = $request['tpersona']['id'];
      //   $persona->perIntPorcmod = 0;
      //   $persona->perIntPorcmix = 0;
      //   $persona->perIntDepencia = 0;
      //   $persona->perTxtEstado = $request['estado']['value'];
      //   $persona->perIntTipogerencia = $request['tgerencia']['ger_id'];
      //   $persona->perTxtNoPasaporte = $request['numpasaporte'];
      //   $persona->perTxtFechaCadPass = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
      //   $persona->perIntCiudadExpPass = $request['ciuexpedicion']['ciuIntId'];
      //   $persona->perIntLifeMiles = $request['lifemiles'];
      //   $persona->save();
      //   /*Fin tabla persona*/
      //
      //   /*Inicio Persona Depende*/
      //   $perdepende = new PerDepende;
      //   $perdepende->perdepPerIntId = $persona->perIntId;
      //   $perdepende->perdepPerIntIdAprueba = 0;
      //   /*canales*/
      //   if ($request['tpersona']['id'] == '1' || $request['tpersona']['id'] == '2') {
      //         $canales = collect($request['canales']);
      //         $canales = $canales->map(function ($canal, $key) {
      //           $canal['can_id'] = trim($canal['can_id']);
      //           return $canal;
      //         });
      //         $pluckedCanal = $canales->pluck('can_id');
      //         $pluckedCanal = $pluckedCanal->implode(',');
      //         $perdepende->perdepIntCanal = $pluckedCanal;
      //   }elseif ($request['tpersona']['id'] == '3' || $request['tpersona']['id'] == '4' || $request['tpersona']['id'] == '5') {
      //         $perdepende->perdepIntCanal = 0;
      //   }
      //   /*fin canales*/
      //   /*territorios*/
      //   if ($request['tpersona']['id'] == '1' || $request['tpersona']['id'] == '3' || $request['tpersona']['id'] == '4' || $request['tpersona']['id'] == '5') {
      //     $perdepende->perdepIntTerritorio = 0;
      //   }elseif ($request['tpersona']['id'] == '2') {
      //     $territorios = collect($request['territorio']);
      //     $pluckedTerr = $territorios->pluck('id');
      //     $pluckedTerr = $pluckedTerr->implode(',');
      //     $perdepende->perdepIntTerritorio = $pluckedTerr;
      //   }
      //   /*fin territorios*/
      //   /*Grupos*/
      //   if ($request['tpersona']['id'] == '1' || $request['tpersona']['id'] == '2' || $request['tpersona']['id'] == '5') {
      //       $perdepende->perdepIntGrupo = 0;
      //   }elseif ($request['tpersona']['id'] == '2' || $request['tpersona']['id'] == '3' ) {
      //     $grupos = collect($request['grupo']);
      //     $pluckedGrupo = $grupos->pluck('gru_sigla');
      //     $pluckedGrupo = $pluckedGrupo->implode(',');
      //     $perdepende->perdepIntGrupo = $pluckedGrupo;
      //   }
      //   /*fin grupos*/
      //   $perdepende->perdepIntPorcentaje = 0;
      //   $perdepende->save();
      //   /*Fin Persona Depende*/
      //   }
      }



}
