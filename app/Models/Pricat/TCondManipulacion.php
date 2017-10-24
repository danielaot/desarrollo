<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TCondManipulacion extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_cond_manipulacion';

    protected $fillable = [
        'tcman_calificador',
        'tcman_nombre'
    ];

}
