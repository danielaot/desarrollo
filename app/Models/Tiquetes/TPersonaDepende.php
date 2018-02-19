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

    public function nivel(){
      return $this->belongsTo('App\Models\Tiquetes\TNivele','perdepIntNivel','id');
    }

    public function aprobador(){
      return $this->hasOne('App\Models\Tiquetes\TPersona', 'perIntId', 'perdepPerIntIdAprueba');
    }

    public function grupo(){
      return $this->hasOne('App\Models\Genericas\TGrupo', 'id', 'perdepIntGrupo');
    }

    public function canal(){
      return $this->hasOne('App\Models\Genericas\TCanal', 'can_id', 'perdepIntCanal');
    }

    public function territorio(){
      return $this->hasOne('App\Models\Genericas\TTerritoriosNw', 'id', 'perdepIntTerritorio');
    }

    public function ejecutivo(){
      return $this->hasOne('App\Models\Tiquetes\TPersona', 'perIntId', 'perdepPerIntId');
    }

    public function perejecutivo(){
      return $this->hasOne('App\Models\Tiquetes\TPernivele', 'pen_cedula', 'perdepPerIntCedPerNivel');
    }
}
