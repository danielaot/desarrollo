<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCompradoresgerencium
 */
class TCompradoresgerencium extends Model
{
    protected $table = 't_compradoresgerencia';

    public $timestamps = false;

    protected $fillable = [
        'comgerTxtIdTercero',
        'comgerIntIdGerencia'
    ];

    protected $guarded = [];


}
