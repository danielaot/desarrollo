<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCiudad extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_ciudad';

    public $timestamps = false;

    protected $fillable = [
        'ciu_id',
        'ciu_txt_nombre',
        'dep_id',
        'pai_id'
    ];
}
