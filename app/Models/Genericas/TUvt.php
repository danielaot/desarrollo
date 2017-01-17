<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TUvt extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_uvt';

    protected $primaryKey = 'uvt_int_codigo';

    public $timestamps = false;

    protected $fillable = [
        'uvt_txt_anioGravable',
        'uvt_txt_valorUvt',
        'uvt_txt_patrimonioBruto',
        'uvt_txt_ingresosTotales',
        'uvt_txt_consumoTarjetaCredito',
        'uvt_txt_comprasConsumos',
        'uvt_txt_consignacionesBancarias'
    ];
}
