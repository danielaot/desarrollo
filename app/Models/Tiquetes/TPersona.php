<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPersona
 */
class TPersona extends Model
{
    protected $connection = 'tiqueteshotel';

    protected $table = 't_persona';

    protected $primaryKey = 'perIntId';

	public $timestamps = false;

    protected $fillable = [
        'perIntId',
        'perTxtNivel',
        'perTxtCedtercero',
        'perTxtNomtercero',
        'perTxtFechaNac',
        'perTxtEmailter',
        'perIntCiudad',
        'perIntTiposolicitud',
        'perIntIdzona',
        'perIntIdcanal',
        'perIntTipopersona',
        'perIntPorcmod',
        'perIntPorcmix',
        'perIntDepencia',
        'perTxtEstado',
        'perIntTipogerencia',
        'perTxtNoPasaporte',
        'perTxtFechaCadPass',
        'perIntCiudadExpPass'
    ];

    public function personaxaprobar(){

      return $this->belongsTo('App\Models\Tiquetes\TPersonaDepende','perIntId','perdepPerIntIdAprueba');
    }

    public function gerencia(){
        return $this->belongsTo('App\Models\Genericas\TGerencia', 'perIntTipogerencia', 'ger_cod');
    }

    public function ciudadpasaporte(){
        return $this->belongsTo('App\Models\Tiquetes\TCiudad', 'perIntCiudadExpPass', 'ciuIntId');
    }

    public function detallenivelpersona(){
        return $this->hasMany('App\Models\Tiquetes\TPersonaDepende', 'perdepPerIntId', 'perIntId');
    }

    public function nivaprobador(){
      return $this->hasOne('App\Models\Tiquetes\TPernivele', 'pen_cedula', 'perTxtCedtercero');
    }

    public function pernivejecutivo(){
      return $this->hasOne('App\Models\Tiquetes\TPernivele', 'pen_cedula', 'perTxtCedtercero');
    }

    public function personasdepende(){
      return $this->hasMany('App\Models\Tiquetes\TPersonaDepende', 'perdepPerIntIdAprueba', 'perIntId');
    }
}
