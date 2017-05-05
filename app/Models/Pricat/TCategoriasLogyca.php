<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TCategoriasLogyca extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_categorias_logyca';

    protected $fillable = [
        'tcl_codigo',
        'tcl_descripcion'
    ];
}
