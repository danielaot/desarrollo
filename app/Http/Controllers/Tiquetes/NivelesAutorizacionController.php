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
use App\Models\NominaACCIONBESA\NominaGerenciasAppWebAnticipos2;
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
      $canal = Canal::with('canalesperniveles')->whereIn('can_id',['20','AL','DR','SI'])->get();
      $territorios = Territorios::with('zona')->get();
      $grupos =  Grupo::with('grupopernivel', 'grupopernivel.nivel')->where('gru_estado',1)->get();
      $usuarios = Tercero::with('usuario', 'dirnacional', 'personanivel', 'persona')
                        ->where('indxEstadoTercero', 1)
                        ->where('indxEmpleadoTercero', 1)
                        ->get();
      $usuarios = collect($usuarios)->map(function($usuario){
      $usuario['cedulaNombre'] = $usuario['idTercero'].' - '.$usuario['razonSocialTercero'];
      return $usuario;
      });

      $usuarios = NominaGerenciasAppWebAnticipos2::obtenerDatosGerenciales($usuarios, true);

      $usuarios = collect($usuarios)->filter(function($usuario){
       return ($usuario->dirnacional != null && $usuario->usuario != null);
      })->values();

      $usuariosSinFiltro = $usuarios;

      $usuarios = collect($usuarios)->filter(function($usuario){
       return ($usuario->usuario != null && $usuario->personanivel == null);
      })->values();

      $gerencias = Gerencia::with('gerenciapernivel')->get();
      $gerencias = collect($gerencias)->map(function($gerencia){
        $gerencia['codigoGerencia'] = $gerencia['ger_cod'].' - '.$gerencia['ger_nom'];
        return $gerencia;
      });
      //$usuarios = NominaGerenciasAppWebAnticipos2::obtenerDatosGerenciales($usuarios, true);

      $niveles = Niveles::all();

      $usuariosN = PerNivel::with('nivel','tipoPersona', 'detpersona.detallenivelpersona.canal', 'detpersona.detallenivelpersona.territorio', 'detpersona.detallenivelpersona.grupo', 'detpersona.personasdepende.ejecutivo', 'detpersona.personasdepende.perejecutivo')->get();

      $usuariosN = collect($usuariosN)->map(function($usuarioN){
      $usuarioN['cedulaNombre'] = $usuarioN['pen_cedula'].' - '.$usuarioN['pen_nombre'];
      return $usuarioN;
      });

      $ciudades = Ciudades::all();


      $response = compact('tpersona', 'canal', 'territorios', 'usuarios', 'grupos', 'gerencias' ,'niveles', 'usuariosN', 'ciudades', 'usuariosSinFiltro');

      return response()->json($response);
    }

    public function savePerNivel(Request $request)
    {
       $existePersona = PerNivel::where('pen_cedula', $request['tercero']['idTercero'])->get();

       if (count($existePersona) === 0) {

         if ($request['nivel']['id'] == 1) {
           /*Tabla Perniveles*/
           $perNivel = new PerNivel;
           $perNivel->pen_usuario = $request['tercero']['usuario']['login'];
           $perNivel->pen_nombre = $request['tercero']['nombreEstablecimientoTercero'];
           $perNivel->pen_cedula = $request['tercero']['idTercero'];
           $perNivel->pen_idtipoper = $request['tpersona']['id'];
           $perNivel->pen_nomnivel = $request['nivel']['id'];
           $perNivel->pen_nivelpadre = 2;
           $perNivel->pen_idgerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
           $perNivel->pen_isServiAdmon = false;
           $perNivel->pen_isCreador = true;
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
           $persona->perIntIdzona = 0;
           $persona->perIntIdcanal = 0;
           $persona->perIntTipopersona = $request['tpersona']['id'];
           $persona->perIntPorcmod = 0;
           $persona->perIntPorcmix = 0;
           $persona->perIntDepencia = 0;
           $persona->perTxtEstado = $request['estado']['value'];
           $persona->perIntTipogerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
           $persona->perTxtNoPasaporte = $request['numpasaporte'];
           $persona->perTxtFechaCadPass = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
           $persona->perIntCiudadExpPass = $request['ciuexpedicion']['ciuIntId'];
           $persona->perIntLifeMiles = $request['lifemiles'];
           $persona->save();
           /*Fin tabla persona*/

           /*Inicio Persona Depende*/
           if ($request['tpersona']['id'] == '1') {
             foreach ($request['canales'] as $key => $value) {
               $perdepende = new PerDepende;
               $perdepende->perdepPerIntId = $persona->perIntId;
               $perdepende->perdepPerIntIdAprueba = 0;
               $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
               $perdepende->perdepPerIntGerencia = 0;
               $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
               $perdepende->perdepIntNivel = $request['nivel']['id'];
               $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
               $perdepende->perdepIntCanal = $value['can_id'];
               $perdepende->perdepIntTerritorio = 0;
               $perdepende->perdepIntGrupo = 0;
               $perdepende->perdepIntPorcentaje = 0;
               $perdepende->save();
             }
            }elseif ($request['tpersona']['id'] == '2') {
              foreach ($request['territorio'] as $key => $value) {
                foreach ($value['canales'] as $key2 => $value2) {
                  $perdepende = new PerDepende;
                  $perdepende->perdepPerIntId = $persona->perIntId;
                  $perdepende->perdepPerIntIdAprueba = 0;
                  $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                  $perdepende->perdepPerIntGerencia = 0;
                  $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                  $perdepende->perdepIntNivel = $request['nivel']['id'];
                  $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                  $perdepende->perdepIntCanal = trim($value2['can_id']);
                  $perdepende->perdepIntTerritorio = $value['id'];
                  $perdepende->perdepIntGrupo = 0;
                  $perdepende->perdepIntPorcentaje = 0;
                  $perdepende->save();
                }
              }
            }elseif ($request['tpersona']['id'] == '3' || $request['tpersona']['id'] == '4') {
             foreach ($request['grupos'] as $key => $value) {
               $perdepende = new PerDepende;
               $perdepende->perdepPerIntId = $persona->perIntId;
               $perdepende->perdepPerIntIdAprueba = 0;
               $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
               $perdepende->perdepPerIntGerencia = 0;
               $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
               $perdepende->perdepIntNivel = $request['nivel']['id'];
               $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
               $perdepende->perdepIntCanal = 0;
               $perdepende->perdepIntTerritorio = 0;
               $perdepende->perdepIntGrupo = $value['id'];
               $perdepende->perdepIntPorcentaje = 0;
               $perdepende->save();
             }
           }elseif ($request['tpersona']['id'] == '5') {
               $perdepende = new PerDepende;
               $perdepende->perdepPerIntId = $persona->perIntId;
               $perdepende->perdepPerIntIdAprueba = 0;
               $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
               $perdepende->perdepPerIntGerencia = 0;
               $perdepende->perdepIntNivel = $request['nivel']['id'];
               $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
               $perdepende->perdepIntCanal = 0;
               $perdepende->perdepIntTerritorio = 0;
               $perdepende->perdepIntGrupo = 0;
               $perdepende->perdepIntPorcentaje = 0;
               $perdepende->save();
           }
           /*Fin Persona Depende*/
        }elseif ($request['nivel']['id'] == 2) {
            /*Tabla Perniveles*/
            $perNivel = new PerNivel;
            $perNivel->pen_usuario = $request['tercero']['usuario']['login'];
            $perNivel->pen_nombre = $request['tercero']['nombreEstablecimientoTercero'];
            $perNivel->pen_cedula = $request['tercero']['idTercero'];
            $perNivel->pen_idtipoper = $request['tpersona']['id'];
            $perNivel->pen_nomnivel = $request['nivel']['id'];
            $perNivel->pen_nivelpadre = 3;
            $perNivel->pen_idgerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
            $perNivel->pen_isServiAdmon = false;
            $perNivel->pen_isCreador = true;
            $perNivel->save();
            /*Fin tabla perniveles*/
            /*Tabla persona*/
            $persona = new Persona;
            $persona->perTxtNivel = 3;
            $persona->perTxtCedtercero = $request['tercero']['idTercero'];
            $persona->perTxtNomtercero = $request['tercero']['nombreEstablecimientoTercero'];
            $persona->perTxtFechaNac = strtotime($request['fnacimiento']);
            $persona->perTxtEmailter = $request['tercero']['dirnacional']['dir_txt_email'];
            $persona->perIntCiudad = 0;
            $persona->perIntTiposolicitud = 0;
            $persona->perIntIdzona = 0;
            $persona->perIntIdcanal = 0;
            $persona->perIntTipopersona = $request['tpersona']['id'];
            $persona->perIntPorcmod = 0;
            $persona->perIntPorcmix = 0;
            $persona->perIntDepencia = 0;
            $persona->perTxtEstado = $request['estado']['value'];
            $persona->perIntTipogerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
            $persona->perTxtNoPasaporte = $request['numpasaporte'];
            $persona->perTxtFechaCadPass = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
            $persona->perIntCiudadExpPass = $request['ciuexpedicion']['ciuIntId'];
            $persona->perIntLifeMiles = $request['lifemiles'];
            $persona->save();
            /*Fin tabla persona*/
            /*Inicio Persona Depende*/
            if ($request['tpersona']['id'] == '1') {
                foreach ($request['canales'] as $key => $value) {
                  $perdepende = new PerDepende;
                  $perdepende->perdepPerIntId = $persona->perIntId;
                  $perdepende->perdepPerIntIdAprueba = 0;
                  $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                  $perdepende->perdepPerIntGerencia = 0;
                  $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                  $perdepende->perdepIntNivel = $request['nivel']['id'];
                  $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                  $perdepende->perdepIntCanal = $value['can_id'];
                  $perdepende->perdepIntTerritorio = 0;
                  $perdepende->perdepIntGrupo = 0;
                  $perdepende->perdepIntPorcentaje = 0;
                  $perdepende->save();
                }

                foreach ($request['canales'] as $key2 => $value2) {
                  foreach ($value2['terceros'] as $key3 => $value3) {
                    $actPersona = PerDepende::where('perdepPerIntCedPerNivel', $value3['pen_cedula'])
                                              ->update(['perdepPerIntIdAprueba' => $persona->perIntId]);

                  }
                }
            }elseif ($request['tpersona']['id'] == '2') {
               foreach ($request['territorio'] as $key => $value) {
                 foreach ($value['canales'] as $key2 => $value2) {
                   $perdepende = new PerDepende;
                   $perdepende->perdepPerIntId = $persona->perIntId;
                   $perdepende->perdepPerIntIdAprueba = 0;
                   $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                   $perdepende->perdepPerIntGerencia = 0;
                   $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                   $perdepende->perdepIntNivel = $request['nivel']['id'];
                   $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                   $perdepende->perdepIntCanal = $value2['can_id'];
                   $perdepende->perdepIntTerritorio = $value['id'];
                   $perdepende->perdepIntGrupo = 0;
                   $perdepende->perdepIntPorcentaje = 0;
                   $perdepende->save();
                 }
               }

               foreach ($request['territorio'] as $key => $value) {
                 foreach ($value['canales'] as $key2 => $value2) {
                   foreach ($value2['terceros'] as $key3 => $value3) {
                     $actPersona = PerDepende::where('perdepPerIntCedPerNivel', $value3['pen_cedula'])
                                              ->update(['perdepPerIntIdAprueba' => $persona->perIntId]);
                   }
                 }
               }
            }elseif ($request['tpersona']['id'] == '3' || $request['tpersona']['id'] == '4') {
                foreach ($request['grupos'] as $key => $value) {
                  foreach ($value['canales'] as $key2 => $value2) {
                    $perdepende = new PerDepende;
                    $perdepende->perdepPerIntId = $persona->perIntId;
                    $perdepende->perdepPerIntIdAprueba = 0;
                    $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                    $perdepende->perdepPerIntGerencia = 0;
                    $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                    $perdepende->perdepIntNivel = $request['nivel']['id'];
                    $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                    $perdepende->perdepIntCanal = $value2['can_id'];
                    $perdepende->perdepIntTerritorio = 0;
                    $perdepende->perdepIntGrupo = $value['id'];
                    $perdepende->perdepIntPorcentaje = 0;
                    $perdepende->save();
                  }
                }
            }elseif ($request['tpersona']['id'] == '5') {
                $perdepende = new PerDepende;
                $perdepende->perdepPerIntId = $persona->perIntId;
                $perdepende->perdepPerIntIdAprueba = 0;
                $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                $perdepende->perdepPerIntGerencia = 0;
                $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                $perdepende->perdepIntNivel = $request['nivel']['id'];
                $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                $perdepende->perdepIntCanal = 0;
                $perdepende->perdepIntTerritorio = 0;
                $perdepende->perdepIntGrupo = 0;
                $perdepende->perdepIntPorcentaje = 0;
                $perdepende->save();

                foreach ($request['personasautoriza'] as $key => $value) {
                  $actPersona = PerDepende::where('perdepPerIntCedPerNivel', $value['pen_cedula'])
                                           ->update(['perdepPerIntIdAprueba' => $persona->perIntId]);
                }
            }
            /*Fin Persona Depende*/
      }elseif ($request['nivel']['id'] == 3) {
     //return response()->json($request);
           /*Tabla Perniveles*/
           $perNivel = new PerNivel;
           $perNivel->pen_usuario = $request['tercero']['usuario']['login'];
           $perNivel->pen_nombre = $request['tercero']['nombreEstablecimientoTercero'];
           $perNivel->pen_cedula = $request['tercero']['idTercero'];
           $perNivel->pen_idtipoper = $request['tpersona']['id'];
           $perNivel->pen_nomnivel = $request['nivel']['id'];
           $perNivel->pen_nivelpadre = 4;
           $perNivel->pen_idgerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
           $perNivel->pen_isServiAdmon = false;
           $perNivel->pen_isCreador = true;
           $perNivel->save();
           /*Fin tabla perniveles*/
           /*Tabla persona*/
           $persona = new Persona;
           $persona->perTxtNivel = 2;
           $persona->perTxtCedtercero = $request['tercero']['idTercero'];
           $persona->perTxtNomtercero = $request['tercero']['nombreEstablecimientoTercero'];
           $persona->perTxtFechaNac = strtotime($request['fnacimiento']);
           $persona->perTxtEmailter = $request['tercero']['dirnacional']['dir_txt_email'];
           $persona->perIntCiudad = 0;
           $persona->perIntTiposolicitud = 0;
           $persona->perIntIdzona = 0;
           $persona->perIntIdcanal = 0;
           $persona->perIntTipopersona = $request['tpersona']['id'];
           $persona->perIntPorcmod = 0;
           $persona->perIntPorcmix = 0;
           $persona->perIntDepencia = 0;
           $persona->perTxtEstado = $request['estado']['value'];
           $persona->perIntTipogerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
           $persona->perTxtNoPasaporte = $request['numpasaporte'];
           $persona->perTxtFechaCadPass = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
           $persona->perIntCiudadExpPass = $request['ciuexpedicion']['ciuIntId'];
           $persona->perIntLifeMiles = $request['lifemiles'];
           $persona->save();
           /*Fin tabla persona*/
           /*Inicio Persona Depende*/
           if ($request['tpersona']['id'] == '1') {
               foreach ($request['canales'] as $key => $value) {
                 $perdepende = new PerDepende;
                 $perdepende->perdepPerIntId = $persona->perIntId;
                 $perdepende->perdepPerIntIdAprueba = 0;
                 $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                 $perdepende->perdepPerIntGerencia = 0;
                 $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                 $perdepende->perdepIntNivel = $request['nivel']['id'];
                 $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                 $perdepende->perdepIntCanal = $value['can_id'];
                 $perdepende->perdepIntTerritorio = 0;
                 $perdepende->perdepIntGrupo = 0;
                 $perdepende->perdepIntPorcentaje = 0;
                 $perdepende->save();
               }

               foreach ($request['canales'] as $key2 => $value2) {
                 foreach ($value2['terceros'] as $key3 => $value3) {
                   $actPersona = PerDepende::where('perdepPerIntCedPerNivel', $value3['pen_cedula'])
                                             ->update(['perdepPerIntIdAprueba' => $persona->perIntId]);

                 }
               }
           }elseif ($request['tpersona']['id'] == '2') {
              foreach ($request['territorio'] as $key => $value) {
                foreach ($value['canales'] as $key2 => $value2) {
                  $perdepende = new PerDepende;
                  $perdepende->perdepPerIntId = $persona->perIntId;
                  $perdepende->perdepPerIntIdAprueba = 0;
                  $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                  $perdepende->perdepPerIntGerencia = 0;
                  $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                  $perdepende->perdepIntNivel = $request['nivel']['id'];
                  $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                  $perdepende->perdepIntCanal = $value2['can_id'];
                  $perdepende->perdepIntTerritorio = $value['id'];
                  $perdepende->perdepIntGrupo = 0;
                  $perdepende->perdepIntPorcentaje = 0;
                  $perdepende->save();
                }
              }

              foreach ($request['territorio'] as $key => $value) {
                foreach ($value['canales'] as $key2 => $value2) {
                  foreach ($value2['terceros'] as $key3 => $value3) {
                    $actPersona = PerDepende::where('perdepPerIntCedPerNivel', $value3['pen_cedula'])
                                             ->update(['perdepPerIntIdAprueba' => $persona->perIntId]);
                  }
                }
              }
            }elseif ($request['tpersona']['id'] == '3' || $request['tpersona']['id'] == '4') {
              foreach ($request['grupos'] as $key => $value) {
                foreach ($value['canales'] as $key2 => $value2) {
                  $perdepende = new PerDepende;
                  $perdepende->perdepPerIntId = $persona->perIntId;
                  $perdepende->perdepPerIntIdAprueba = 0;
                  $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
                  $perdepende->perdepPerIntGerencia = 0;
                  $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
                  $perdepende->perdepIntNivel = $request['nivel']['id'];
                  $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
                  $perdepende->perdepIntCanal = $value2['can_id'];
                  $perdepende->perdepIntTerritorio = 0;
                  $perdepende->perdepIntGrupo = $value['id'];
                  $perdepende->perdepIntPorcentaje = 0;
                  $perdepende->save();
                }
              }
           }elseif ($request['tpersona']['id'] == '5') {
               $perdepende = new PerDepende;
               $perdepende->perdepPerIntId = $persona->perIntId;
               $perdepende->perdepPerIntIdAprueba = 0;
               $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
               $perdepende->perdepPerIntGerencia = 0;
               $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
               $perdepende->perdepIntNivel = $request['nivel']['id'];
               $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
               $perdepende->perdepIntCanal = 0;
               $perdepende->perdepIntTerritorio = 0;
               $perdepende->perdepIntGrupo = 0;
               $perdepende->perdepIntPorcentaje = 0;
               $perdepende->save();

               foreach ($request['personasautoriza'] as $key => $value) {
                 $actPersona = PerDepende::where('perdepPerIntCedPerNivel', $value['pen_cedula'])
                                          ->update(['perdepPerIntIdAprueba' => $persona->perIntId]);
               }
           }
           /*Fin Persona Depende*/
      }elseif ($request['nivel']['id'] == 4) {
          /*Tabla Perniveles*/
          $perNivel = new PerNivel;
          $perNivel->pen_usuario = $request['tercero']['usuario']['login'];
          $perNivel->pen_nombre = $request['tercero']['nombreEstablecimientoTercero'];
          $perNivel->pen_cedula = $request['tercero']['idTercero'];
          $perNivel->pen_idtipoper = $request['tpersona']['id'];
          $perNivel->pen_nomnivel = $request['nivel']['id'];
          $perNivel->pen_nivelpadre = 0;
          $perNivel->pen_idgerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
          $perNivel->pen_isServiAdmon = false;
          $perNivel->pen_isCreador = true;
          $perNivel->save();
          /*Fin tabla perniveles*/
          /*Tabla persona*/
          $persona = new Persona;
          $persona->perTxtNivel = 1;
          $persona->perTxtCedtercero = $request['tercero']['idTercero'];
          $persona->perTxtNomtercero = $request['tercero']['nombreEstablecimientoTercero'];
          $persona->perTxtFechaNac = strtotime($request['fnacimiento']);
          $persona->perTxtEmailter = $request['tercero']['dirnacional']['dir_txt_email'];
          $persona->perIntCiudad = 0;
          $persona->perIntTiposolicitud = 0;
          $persona->perIntIdzona = 0;
          $persona->perIntIdcanal = 0;
          $persona->perIntTipopersona = $request['tpersona']['id'];
          $persona->perIntPorcmod = 0;
          $persona->perIntPorcmix = 0;
          $persona->perIntDepencia = 0;
          $persona->perTxtEstado = $request['estado']['value'];
          $persona->perIntTipogerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
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
          $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
          $perdepende->perdepPerIntGerencia = 0;
          $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
          $perdepende->perdepIntNivel = $request['nivel']['id'];
          $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
          $perdepende->perdepIntCanal = 0;
          $perdepende->perdepIntTerritorio = 0;
          $perdepende->perdepIntGrupo = 0;
          $perdepende->perdepIntPorcentaje = 0;
          $perdepende->save();
          /*Fin persona depende*/
        }elseif ($request['nivel']['id'] == 5) {
            /*Tabla Perniveles*/
            $perNivel = new PerNivel;
            $perNivel->pen_usuario = $request['tercero']['usuario']['login'];
            $perNivel->pen_nombre = $request['tercero']['nombreEstablecimientoTercero'];
            $perNivel->pen_cedula = $request['tercero']['idTercero'];
            $perNivel->pen_idtipoper = $request['tpersona']['id'];
            $perNivel->pen_nomnivel = $request['nivel']['id'];
            $perNivel->pen_nivelpadre = 0;
            $perNivel->pen_idgerencia = $request['tercero']['datosGerencia']['cod_gerencia'];
            $perNivel->pen_isServiAdmon = true;
            $perNivel->pen_isCreador = false;
            $perNivel->save();

            /*Fin tabla perniveles*/
            /*Tabla persona*/
            $persona = new Persona;
            $persona->perTxtNivel = 1;
            $persona->perTxtCedtercero = $request['tercero']['idTercero'];
            $persona->perTxtNomtercero = $request['tercero']['nombreEstablecimientoTercero'];
            $persona->perTxtFechaNac = strtotime($request['fnacimiento']);
            $persona->perTxtEmailter = $request['tercero']['dirnacional']['dir_txt_email'];
            $persona->perIntCiudad = 0;
            $persona->perIntTiposolicitud = 0;
            $persona->perIntIdzona = 0;
            $persona->perIntIdcanal = 0;
            $persona->perIntTipopersona = $request['tpersona']['id'];
            $persona->perIntPorcmod = 0;
            $persona->perIntPorcmix = 0;
            $persona->perIntDepencia = 0;
            $persona->perTxtEstado = $request['estado']['value'];
            $persona->perIntTipogerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
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
            $perdepende->perdepPerIntCedPerNivel = $perNivel->pen_cedula;
            $perdepende->perdepPerIntGerencia = 0;
            $perdepende->perdepPerIntIdtipoper = $request['tpersona']['id'];
            $perdepende->perdepIntNivel = $request['nivel']['id'];
            $perdepende->perdepPerIntGerencia = trim($request['tercero']['datosGerencia']['cod_gerencia']);
            $perdepende->perdepIntCanal = 0;
            $perdepende->perdepIntTerritorio = 0;
            $perdepende->perdepIntGrupo = 0;
            $perdepende->perdepIntPorcentaje = 0;
            $perdepende->save();
            /*Fin persona depende*/
          }
        return response()->json($request);
    }
  }

    public function update(Request $request){
      //return response()->json($request);
      if ($request['nivel']['id'] == 1) {
        /*Tabla Perniveles*/
        $pernivel = PerNivel::where('id', $request['idpernivel'])
                            ->update(['pen_usuario' => $request['nuevoBeneficiario']['usuario']['login'],
                                      'pen_nombre' => $request['nuevoBeneficiario']['nombreEstablecimientoTercero'],
                                      'pen_cedula' => $request['nuevoBeneficiario']['idTercero'],
                                      'pen_idtipoper' => $request['tipo_persona']['id'],
                                      'pen_nomnivel' => $request['nivel']['id'],
                                      'pen_nivelpadre' => 2]);

        /*Fin tabla perniveles*/
        /*Tabla persona*/
        $fechaNacimiento = strtotime($request['fnacimiento']);
        $fechaPasaporte = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
        $persona = Persona::where('perTxtCedtercero', $request['nuevoBeneficiario']['idTercero'])
                          ->update(['perTxtNivel' => 4,
                                    'perTxtCedtercero'=> $request['nuevoBeneficiario']['idTercero'],
                                    'perTxtNomtercero' => $request['nuevoBeneficiario']['nombreEstablecimientoTercero'],
                                    'perTxtEmailter' => $request['nuevoBeneficiario']['dirnacional']['dir_txt_email'],
                                    'perIntCiudad' => 0, 'perIntTiposolicitud' => 0,
                                    'perIntIdzona' => 0, 'perIntIdcanal' => 0,
                                    'perIntTipopersona' => $request['tipo_persona']['id'],
                                    'perIntPorcmod' => 0, 'perIntPorcmix' => 0, 'perIntDepencia' => 0,
                                    'perTxtEstado' => $request['estado']['value'],
                                    'perIntTipogerencia' => trim($request['nuevoBeneficiario']['datosGerencia']['cod_gerencia']),
                                    'perTxtNoPasaporte' => $request['numpasaporte'],
                                    'perTxtFechaCadPass' => $fechaPasaporte,
                                    'perIntCiudadExpPass' => $request['ciuexpedicion']['ciuIntId'],
                                    'perIntLifeMiles' => $request['lifemiles']]);
        /*Fin tabla persona*/

        /*Inicio Persona Depende*/
        if ($request['tipo_persona']['id'] == '1') {

          $canales = $request['canales'];
          $buscaCanal = collect($canales)->filter(function ($canal, $key){
            return (!isset($canal['isNew']));
          });

//return response()->json($request);
          foreach ($buscaCanal as $key => $value) {

              $perdepende = new PerDepende;
              $perdepende->perdepPerIntId = $request['nuevoBeneficiario']['persona']['perIntId'];
              $perdepende->perdepPerIntIdAprueba = 0;
              $perdepende->perdepPerIntCedPerNivel = $request['nuevoBeneficiario']['personanivel']['pen_cedula'];
              $perdepende->perdepPerIntGerencia = trim($request['nuevoBeneficiario']['datosGerencia']['cod_gerencia']);
              $perdepende->perdepPerIntIdtipoper = $request['nuevoBeneficiario']['personanivel']['pen_idtipoper'];
              $perdepende->perdepIntNivel = $request['nivel']['id'];
              $perdepende->perdepIntCanal = $value['can_id'];
              $perdepende->perdepIntTerritorio = 0;
              $perdepende->perdepIntGrupo = 0;
              $perdepende->perdepIntPorcentaje = 0;
              $perdepende->save();

          }
        }elseif ($request['tipo_persona']['id'] == '2') {
          
            foreach ($request['territorios'] as $key => $value) {
              if ($value['isNew']  == true){
                foreach ($value['canales'] as $key2 => $value2) {
                  $perdepende = new PerDepende;
                  $perdepende->perdepPerIntId = $request['nuevoBeneficiario']['persona']['perIntId'];
                  $perdepende->perdepPerIntIdAprueba = 0;
                  $perdepende->perdepPerIntCedPerNivel = $request['pen_cedula'];
                  $perdepende->perdepPerIntGerencia = 0;
                  $perdepende->perdepPerIntIdtipoper = $request['tipo_persona']['id'];
                  $perdepende->perdepIntNivel = $request['nivel']['id'];
                  $perdepende->perdepPerIntGerencia = trim($request['nuevoBeneficiario']['datosGerencia']['cod_gerencia']);
                  $perdepende->perdepIntCanal = trim($value2['can_id']);
                  $perdepende->perdepIntTerritorio = $value['id'];
                  $perdepende->perdepIntGrupo = 0;
                  $perdepende->perdepIntPorcentaje = 0;
                  $perdepende->save();
                }
              }
            }

        }elseif ($request['tipo_persona']['id'] == '3' || $request['tipo_persona']['id'] == '4') {

          foreach ($request['grupos'] as $key => $value) {

            $existeGrupo = PerDepende::where('perdepPerIntCedPerNivel', $request['nuevoBeneficiario']['idTercero'])->where('perdepIntGrupo', $value['id'])->get();

              if (count($existeGrupo) == 0)  {
                  $perdepende = new PerDepende;
                  $perdepende->perdepPerIntId = $request['nuevoBeneficiario']['persona']['perIntId'];
                  $perdepende->perdepPerIntIdAprueba = 0;
                  $perdepende->perdepPerIntCedPerNivel = $request['pen_cedula'];
                  $perdepende->perdepPerIntGerencia = 0;
                  $perdepende->perdepPerIntIdtipoper = $request['tipo_persona']['id'];
                  $perdepende->perdepIntNivel = $request['nivel']['id'];
                  $perdepende->perdepPerIntGerencia = trim($request['nuevoBeneficiario']['datosGerencia']['cod_gerencia']);
                  $perdepende->perdepIntCanal = 0;
                  $perdepende->perdepIntTerritorio = 0;
                  $perdepende->perdepIntGrupo = $value['id'];
                  $perdepende->perdepIntPorcentaje = 0;
                  $perdepende->save();
              }
          }
        }
        /*Fin Persona Depende*/


      }elseif ($request['nivel']['id'] == 2) {

        /*Tabla Perniveles*/
        $pernivel = PerNivel::where('id', $request['idpernivel'])
                            ->update(['pen_usuario' => $request['nuevoBeneficiario']['usuario']['login'],
                                      'pen_nombre' => $request['nuevoBeneficiario']['nombreEstablecimientoTercero'],
                                      'pen_cedula' => $request['nuevoBeneficiario']['idTercero'],
                                      'pen_idtipoper' => $request['tipo_persona']['id'],
                                      'pen_nomnivel' => $request['nivel']['id'],
                                      'pen_nivelpadre' => 3]);

        /*Fin tabla perniveles*/
        /*Tabla persona*/
        $fechaNacimiento = strtotime($request['fnacimiento']);
        $fechaPasaporte = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
        $persona = Persona::where('perTxtCedtercero', $request['nuevoBeneficiario']['idTercero'])
                          ->update(['perTxtNivel' => 3,
                                    'perTxtCedtercero'=> $request['nuevoBeneficiario']['idTercero'],
                                    'perTxtNomtercero' => $request['nuevoBeneficiario']['nombreEstablecimientoTercero'],
                                    'perTxtEmailter' => $request['nuevoBeneficiario']['dirnacional']['dir_txt_email'],
                                    'perIntCiudad' => 0, 'perIntTiposolicitud' => 0,
                                    'perIntIdzona' => 0, 'perIntIdcanal' => 0,
                                    'perIntTipopersona' => $request['tipo_persona']['id'],
                                    'perIntPorcmod' => 0, 'perIntPorcmix' => 0, 'perIntDepencia' => 0,
                                    'perTxtEstado' => $request['estado']['value'],
                                    'perIntTipogerencia' => $request['nuevoBeneficiario']['datosGerencia']['cod_gerencia'],
                                    'perTxtNoPasaporte' => $request['numpasaporte'],
                                    'perTxtFechaCadPass' => $fechaPasaporte,
                                    'perIntCiudadExpPass' => $request['ciuexpedicion']['ciuIntId'],
                                    'perIntLifeMiles' => $request['lifemiles']]);
        /*Fin tabla persona*/
        /*Inicio tabla Persona Depende*/

        /*fin tabla Persona Depende*/
      }elseif ($request['nivel']['id'] == 3) {
        # code...
      }elseif ($request['nivel']['id'] == 4) {
        # code...
      }elseif ($request['nivel']['id'] == 5) {

        /*Tabla Perniveles*/
        $pernivel = PerNivel::where('id', $request['idpernivel'])
                            ->update(['pen_usuario' => $request['tercero']['usuario']['login'],
                                      'pen_nombre' => $request['tercero']['nombreEstablecimientoTercero'],
                                      'pen_cedula' => $request['tercero']['idTercero'],
                                      'pen_idtipoper' => $request['tpersona']['id'],
                                      'pen_nomnivel' => $request['nivel']['id'],
                                      'pen_nivelpadre' => 3]);

        /*Fin tabla perniveles*/
        /*Tabla persona*/
        $fechaNacimiento = strtotime($request['fnacimiento']);
        $fechaPasaporte = Carbon::parse($request['fpasaporte'])->format('Y-m-d');
        $persona = Persona::where('perTxtCedtercero', $request['tercero']['idTercero'])
                          ->update(['perTxtNivel' => 3,
                                    'perTxtCedtercero'=> $request['tercero']['idTercero'],
                                    'perTxtNomtercero' => $request['tercero']['nombreEstablecimientoTercero'],
                                    'perTxtEmailter' => $request['tercero']['dirnacional']['dir_txt_email'],
                                    'perIntCiudad' => 0, 'perIntTiposolicitud' => 0,
                                    'perIntIdzona' => 0, 'perIntIdcanal' => 0,
                                    'perIntTipopersona' => $request['tpersona']['id'],
                                    'perIntPorcmod' => 0, 'perIntPorcmix' => 0, 'perIntDepencia' => 0,
                                    'perTxtEstado' => $request['estado']['value'],
                                    'perIntTipogerencia' => $request['tercero']['datosGerencia']['cod_gerencia'],
                                    'perTxtNoPasaporte' => $request['numpasaporte'],
                                    'perTxtFechaCadPass' => $fechaPasaporte,
                                    'perIntCiudadExpPass' => $request['ciuexpedicion']['ciuIntId'],
                                    'perIntLifeMiles' => $request['lifemiles']]);
        /*Fin tabla persona*/
      }
  }

  public function deletePerNivel(Request $request){

      $pernivel = PerNivel::find($request['id']);
      $pernivel->delete();

      $persona = Persona::find($request['detpersona']['perIntId']);
      $persona->delete();

      foreach ($request['detpersona']['detallenivelpersona'] as $key => $value) {
        $perdepende = PerDepende::find($value['id']);
        $perdepende->delete();
      }
  }



}
