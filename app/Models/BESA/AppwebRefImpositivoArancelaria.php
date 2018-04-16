<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class AppwebRefImpositivoArancelaria extends Model
{
    protected $connection = 'besa';

    protected $table = '9000-appweb_ref_impositivo_arancelaria';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'f_referencia',
        'f_descripcion',
        'f_grupo_impositivo',
        'f_pos_arancelaria'
    ];
}
