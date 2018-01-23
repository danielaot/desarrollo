<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TZonaNw extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_zonas_nw';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'znw_descripcion',
        'znw_estado'
    ];
}
