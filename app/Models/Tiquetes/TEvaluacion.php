<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TEvaluacion
 */
class TEvaluacion extends Model
{   
    protected $connection = 'tiqueteshotel';
    
    protected $table = 't_evaluacion';

    protected $primaryKey = 'evaIntid';

	public $timestamps = false;

    protected $fillable = [
        'evaIntSolicitud',
        'evaTxtCedtercero',
        'evaTxtnombreter',
        'evatxtObservacione',
        'evaIntFecha',
        'evaTxtCedterAnt',
        'evaTxtNomterAnt',
        'evaIntTipoSolicitudAnt',
        'evaEstado'
    ];

    protected $guarded = [];

    public function estado(){
      return $this->hasOne('App\Models\Tiquetes\TEstados', 'id', 'evaIntTipoSolicitudAnt');
    }

    public function solicitud(){
      return $this->belongsTo('App\Models\Tiquetes\TSolicitud', 'evaIntSolicitud', 'solIntSolId');
    }
}
