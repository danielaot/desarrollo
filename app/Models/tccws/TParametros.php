<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class tccwsTDoctoDespachostcc
 */
class TParametros extends Model
{
    use SoftDeletes;

    protected $connection = 'conectortccws';

    protected $table = 't_parametros';

    public $timestamps = true;

    protected $fillable = [
        'par_campoTcc',
        'par_campoVariable',
        'par_valor',
        'par_grupo'
    ];

    protected $dates = ['deleted_at'];


}