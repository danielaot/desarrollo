<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicitud
 */
class TSolicitud extends Model
{
    protected $table = 't_solicitud';

    protected $primaryKey = 'solIntSolId';

	public $timestamps = false;

    protected $fillable = [
        'solIntFecha',
        'solTxtCedterceroCrea',
        'solIntPersona',
        'solTxtCedtercero',
        'solTxtNomtercero',
        'solTxtEmail',
        'solIntFNacimiento',
        'solTxtObservacion',
        'solIntEstado',
        'solIntTiposolicitud',
        'solTxtTipoNU',
        'solTxtSolAnterior',
        'solTxtMotivotarde',
        'solTxtPerExterna',
        'solTxtNumTelefono',
        'solIntIdCanal',
        'solIntIdZona'
    ];

    protected $guarded = [];

    public function detalle(){
      return $this->hasMany('App\Models\Tiquetes\TDetallesolictud', 'dtaIntSolicitud', 'solIntSolId');
    }


}
