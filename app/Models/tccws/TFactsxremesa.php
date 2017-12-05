<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TFactsxremesa
 */
class TFactsxremesa extends Model
{

    protected $connection = 'conectortccws';
    
    protected $table = 't_factsxremesa';

    public $timestamps = true;

    protected $fillable = [
        'fxr_remesa',
        'fxr_tipodocto',
        'fxr_numerodocto',
        'fxr_fechadocto'
    ];

    protected $guarded = [];


}
