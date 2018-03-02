<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicitud
 */
class TSolicitud extends Model
{
    protected $connection = 'tiqueteshotel';

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

    public function perAutoriza(){
      return $this->hasOne('App\Models\Tiquetes\TPersonaDepende', 'perdepPerIntCedPerNivel', 'solTxtCedtercero');
    }

    public function pago(){
      return $this->hasOne('App\Models\Tiquetes\TPago', 'pagIntSolicitud', 'solIntSolId');
    }

    public function solipernivel(){
      return $this->hasOne('App\Models\Tiquetes\TSolipernivel', 'sni_idsolicitud', 'solIntSolId');
    }


    public function canal(){
      return $this->hasOne('App\Models\Genericas\TCanal', 'can_id', 'solIntIdCanal');
    }

    public function grupoaprobacion(){
      return $this->hasOne('App\Models\Genericas\TGrupo', 'id', 'solIntIdGrupo');
    }

    public function territorioaprobacion(){
      return $this->hasOne('App\Models\Genericas\TTerritoriosNw', 'id', 'solIntIdZona');
    }

    public function tipoGerencia(){
      return $this->hasOne('App\Models\Genericas\TGerencia', 'ger_cod' ,'solTxtGerencia');
    }
    
    public function evaluaciones(){
        return $this->hasMany('App\Models\Tiquetes\TEvaluacion', 'evaIntSolicitud', 'solIntSolId');
    }

    public function personaGerencia(){
        return $this->hasOne('App\Models\Tiquetes\TPersona', 'perTxtCedtercero', 'solTxtCedtercero');

    }
}
