<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TTipoEmbalaje extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_tipo_embalajes';

    protected $fillable = [
        'temb_calificador',
        'temb_nombre'
    ];

}
