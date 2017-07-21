<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class AppwebGrupoimpo extends Model
{
    protected $connection = 'besa';

    protected $table = '9000-appweb_grupoimpo';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'cod_grupoimpo',
        'desc_grupoimpo'
    ];
}
