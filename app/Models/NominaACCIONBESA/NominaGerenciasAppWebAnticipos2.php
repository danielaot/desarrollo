<?php

namespace App\Models\NominaACCIONBESA;

use Illuminate\Database\Eloquent\Model;
use DB;

class NominaGerenciasAppWebAnticipos2 extends Model
{
    protected $connection = 'nominabesa';

    protected $table = '00_nomina85_Gerencias_AppWeb_Anticipos2';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'nit_beneficiario',
        'nom_beneficiario',
        'cod_gerencia',
        'nom_gerencia',
        'cod_ccosto',
        'num_ccosto',
        'cod_co',
        'desc_co',
        'cod_co_n1',
        'desc_co_n1',
        'cod_cargo',
        'nom_cargo'
    ];


    public static function obtenerDatosGerenciales($usuarios,$isStdClass = false){

        if(count($usuarios) > 0){
            if($isStdClass == false){
        		$usuario = collect($terceros)->map(function($usuario){
        			$usuario['datosGerencia'] = null;
                    $consultaGerencia = DB::connection('nominabesa')
                    ->table('00_nomina85_Gerencias_AppWeb_Anticipos2')
                    ->select('cod_gerencia','nom_gerencia')
                    ->where('nit_beneficiario', $usuario['directorionacional']['dir_txt_cedula'])
                    ->first();

                    if($consultaGerencia == null){
                        $usuario['datosGerencia'] = ['cod_gerencia' => 'GC', 'nom_gerencia' => 'GERENCIA COMERCIAL'];
                    }else{
                        $usuario['datosGerencia'] = $consultaGerencia;
                    }

        			return $usuario;
        		});
            }else{
                $usuarios = collect($usuarios)->map(function($usuario){
                    $usuario['datosGerencia'] = null;
                    $consultaGerencia = DB::connection('nominabesa')
                    ->table('00_nomina85_Gerencias_AppWeb_Anticipos2')
                    ->select('cod_gerencia','nom_gerencia')
                    ->where('nit_beneficiario', $usuario['idTercero'])
                    ->first();

                    if($consultaGerencia == null){
                        $usuario['datosGerencia'] = ['cod_gerencia' => 'GC', 'nom_gerencia' => 'GERENCIA COMERCIAL'];
                    }else{
                        $usuario['datosGerencia'] = $consultaGerencia;
                    }

                    return $usuario;
                });
            }
        }

    	return $usuarios;
    }
}
