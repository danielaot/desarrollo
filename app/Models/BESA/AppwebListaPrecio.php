<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class AppwebListaPrecio extends Model
{
    protected $connection = 'unoeereal';

    protected $table = 't112_mc_listas_precios';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'f112_id',
        'f112_descripcion'
    ];
}
