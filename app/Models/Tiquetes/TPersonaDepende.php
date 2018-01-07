<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPersonaDepende
 */
class TPersonaDepende extends Model
{

    protected $connection = 'tiqueteshotel';

    protected $table = 't_persona_depende';

    public $timestamps = false;

    protected $fillable = [
        'perdepPerIntId',
        'perdepPerIntIdAprueba',
        'perdepIntCanal',
        'perdepIntPorcentaje'
    ];


    public function aprueba(){

      return $this->belongsTo('App\Models\Tiquetes\TPersona', 'perdepPerIntIdAprueba', 'perIntId');
    }

    public function infopersona(){
      return $this->hasOne('App\Models\Tiquetes\TPersona', 'perIntId', 'perdepPerIntId');
    }

}
