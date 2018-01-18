<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class wstccFacturasInfo extends Model
{
    protected $connection = 'besa';

    protected $table = '0_wstcc_facturas';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'v470_id_fecha',
        'f_tipo_docto',
        'f_consec_docto',
        'v470_vlr_subtotal',
        'v470_cant_1',
        'v470_num_ref'
    ];
}
