<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TBodega extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_bodega';

    protected $primaryKey = 'bod_id';

    public $timestamps = false;

    protected $fillable = [
        'cen_id',
        'bod_txt_abreviatura',
        'bod_txt_descripcion',
    ];
}
