<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCentroCosto extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_centro_costo';

    protected $primaryKey = 'cco_id';

    public $timestamps = false;

    protected $fillable = [
        'cco_cod',
        'cco_nom',
        'cco_nom_corto',
        'cco_ger_id',
    ];
}
