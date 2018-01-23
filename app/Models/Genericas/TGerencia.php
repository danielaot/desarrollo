<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TGrupo
 */
class TGerencia extends Model
{
    protected $table = 't_gerencia';

    protected $connection = 'genericas';

    public $timestamps = false;

    protected $fillable = [
        'ger_id',
        'ger_cod',
        'ger_nom',
        'ger_nom_corto'
    ];

    protected $guarded = [];


}
