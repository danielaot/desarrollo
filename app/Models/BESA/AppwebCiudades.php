<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class AppwebCiudades extends Model
{
    protected $connection = 'besa';

    protected $table = '9000-appweb_ciudades';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'cod_depto',
        'desc_depto',
        'cod_ciudad',
        'des_ciudad'
    ];
}