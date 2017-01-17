<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCargo extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_cargo';

    protected $primaryKey = 'car_id';

    public $timestamps = false;

    protected $fillable = [
        'car_cod',
        'car_nom',
        'car_per',
    ];
}
