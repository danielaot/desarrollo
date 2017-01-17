<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCargoTercero extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_cargo_tercero';

    public $timestamps = false;

    protected $fillable = [
        'codigoCargo',
        'idTerceroCargo',
        'fechaInicioCargo',
        'cco_id',
        'tca_id',
        'car_jefe_id',
    ];
}
