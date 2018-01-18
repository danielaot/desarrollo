<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TDoctoDespachostcc
 */
class TDoctoDespachostcc extends Model
{
    use SoftDeletes;

    protected $connection = 'conectoressiesa';

    protected $table = 't_docto_despachostcc';

    public $timestamps = true;

    protected $fillable = [
        'ddt_nombre',
        'ddt_campo',
        'ddt_segmento',
        'ddt_longitud',
        'ddt_tipo',
        'ddt_orden',
        'ddt_grupo'
    ];

    protected $guarded = [];
    protected $dates = ['deleted_at'];


}
