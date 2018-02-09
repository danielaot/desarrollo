<?php

namespace App\Models\tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolipernivel
 */
class TSolipernivel extends Model
{
    protected $table = 't_solipernivel';

    public $timestamps = true;

    protected $fillable = [
        'sni_idpernivel',
        'sni_cedula',
        'sni_idsolicitud',
        'sni_estado',
        'sni_orden'
    ];

    protected $guarded = [];

    public function detallepernivel(){
      return $this->hasOne('App\Models\Tiquetes\TPernivele','pen_cedula','sni_cedula');
    }

    public function detallesolicitud(){
      return $this->hasOne('App\Models\Tiquetes\TSolicitud','solIntSolId','sni_idsolicitud');
    }
}
