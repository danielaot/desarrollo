<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TTipoCargo extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_tipo_cargo';

    protected $primaryKey = 'tca_id';

    public $timestamps = false;

    protected $fillable = [
        'tca_cod',
        'tca_nom'
    ];
}
