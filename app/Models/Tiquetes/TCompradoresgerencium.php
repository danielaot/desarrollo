<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCompradoresgerencium
 */
class TCompradoresgerencium extends Model
{
    protected $connection = 'tiqueteshotel';

    protected $table = 't_compradoresgerencia';

    public $timestamps = false;

    protected $fillable = [
        'comgerTxtIdTercero',
        'comgerIntIdGerencia'
    ];

    protected $guarded = [];

    public function datocomprador(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'comgerTxtIdTercero');
    }

}
