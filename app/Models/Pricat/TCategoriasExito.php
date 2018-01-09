<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TCategoriasExito extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_categorias_exito';

    protected $fillable = [
        'tce_codigo',
        'tce_descripcion'
    ];
}
