<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;
use DB;

class PreciosReferencias extends Model
{
    protected $connection = 'besa';

    protected $table = '000_LP-003_RNF_tbl';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'lp',
        'listaprecio',
        'referencia',
        'descripcion',
        'fecha_activacion',
        'precio',
        'cod_linea',
        'nom_linea',
        'cod_categoria',
        'nom_categoria',
        'prom_regular',
        'estado_criterio',
        'cod_sublinea',
        'nom_sublinea',
        'cod_sublinea_mcdeo',
        'nom_sublinea_mcdeo',
        'llave',
    ];

    public static function consultarReferencia($referencia){

            $objeto = DB::connection('besa')->table('000_LP-003_RNF_tbl')
            ->select('lp','referencia','cod_linea','nom_linea','cod_categoria','precio','estado_criterio','llave')
            ->where('lp','RNF')
            ->where('referencia',$referencia)
            ->where('llave','like','%UND%')
            ->orWhere('lp','RNF')
            ->where('referencia',$referencia)
            ->where('llave','like','%PAR%')
            ->orderBy('fecha_activacion','desc')->get();

            return $objeto;
    }



    public static function consultarReferencias($referencias){

            $objetos = DB::connection('besa')->table('000_LP-003_RNF_tbl')
            ->select('lp','referencia','cod_linea','nom_linea','cod_categoria','precio','estado_criterio','llave')
            ->where('lp','RNF')
            ->whereIn('referencia',$referencias)
            ->where('llave','like','%UND%')
            ->orWhere('lp','RNF')
            ->whereIn('referencia',$referencias)
            ->where('llave','like','%PAR%')
            ->orderBy('fecha_activacion','desc')->get();

            return $objetos;
    }


}
