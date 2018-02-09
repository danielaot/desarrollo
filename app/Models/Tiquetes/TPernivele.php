<?php

namespace App\Models\tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPernivele
 */
class TPernivele extends Model
{
    protected $connection = 'tiqueteshotel';

    protected $table = 't_perniveles';

    public $timestamps = true;

    protected $fillable = [
        'pen_usuario',
        'pen_nombre',
        'pen_cedula',
        'pen_idtipoper',
        'pen_nomnivel',
        'pen_idterritorios'
    ];

    protected $guarded = [];

    public function tipoPersona(){
      return $this->belongsTo('App\Models\Genericas\TTipopersona','pen_idtipoper','id');
    }

    public function detpersona(){
      return $this->belongsTo('App\Models\Tiquetes\TPersona','pen_cedula','perTxtCedtercero');
    }

    public function nivel(){
      return $this->belongsTo('App\Models\Tiquetes\TNivele','pen_nomnivel','id');
    }

    public function detalle(){
      return $this->hasMany('App\Models\Tiquetes\TPersonaDepende','perdepPerIntCedPerNivel','pen_cedula');
    }
}
