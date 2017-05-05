<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TTipoEmpEmb extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_tipo_emp_emb';

    protected $fillable = [
        'tem_calificador',
        'tem_nombre'
    ];

}
