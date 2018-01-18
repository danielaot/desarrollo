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

    public function estados(){
      return $this->hasOne('App\Models\Tiquetes\TEstados', 'id', 'solIntEstado');
    }

    public function perExterna(){
      return $this->hasOne('App\Models\Tiquetes\TPersonaexterna', 'pereIntSolId', 'solIntSolId');
    }

    public function perCrea(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'solTxtCedterceroCrea');
    }

    public function pago(){
      return $this->hasOne('App\Models\Tiquetes\TPago', 'pagIntSolicitud', 'solIntSolId');
    }

}
