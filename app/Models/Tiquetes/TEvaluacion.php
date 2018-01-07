<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TEvaluacion
 */
class TEvaluacion extends Model
{
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


}
