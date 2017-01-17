<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TVendedor extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_vendedor';

    public $timestamps = false;

    protected $fillable = [
        'ven_id',
        'ter_id',
    ];
}
