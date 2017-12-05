<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class tccwsTDoctoDespachostcc
 */
class TPruebaCartera extends Model
{
    use SoftDeletes;

    protected $connection = 'conectortccws';

    protected $table = 't_prucartera';

    public $timestamps = true;

    protected $fillable = [
        'prc_numero',
        'prc_suma',
        'prc_formulas'
    ];

    protected $dates = ['deleted_at'];

}