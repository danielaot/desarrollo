<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TTipoEmpaque extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_tipo_empaques';

    protected $fillable = [
        'temp_calificador',
        'temp_nombre'
    ];

}
