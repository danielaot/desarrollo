<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class LineasProducto extends Model
{
    protected $connection = 'besa';

    protected $table = '200_LineasProducto';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'CodLinea',
        'NomLinea'
    ];
}
