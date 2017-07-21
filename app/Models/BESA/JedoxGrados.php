<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class JedoxGrados extends Model
{
    protected $connection = 'besa';

    protected $table = '0_jedox_grados';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'f_referencia',
        'f_descripcion',
        'f_codigolinea',
        'f_nombrelinea',
        'f_codigocentrotrabajo',
        'f_descripcionct',
        'f_grados',
        'f_codigooperacion',
        'f_descripcionop',
        'f_tipogrado',
        'f_vlr_tam_cont',
        'f_um_tam_cont',
        'cant',
        'tarifa_externa'
    ];
}
