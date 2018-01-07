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
}
