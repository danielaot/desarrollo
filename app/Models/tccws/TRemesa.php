<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRemesa
 */
class TRemesa extends Model
{
    protected $connection = 'conectortccws';

    protected $table = 't_remesas';

    public $timestamps = true;

    protected $fillable = [
        'rms_remesa',
        'rms_observacion',
        'rms_terceroid',
        'rms_sucu_cod',
        'rms_txt_vehiculo',
        'rms_ciud_sucursal',
        'rms_nom_sucursal',
        'rms_cajas',
        'rms_lios',
        'rms_pesolios',
        'rms_pesoliostcc',
        'rms_palets',
        'rms_pesopalets',
        'rms_pesopaletstcc',
        'rms_pesototal',
        'rms_remesapadre',
        'rms_isBoomerang'
    ];

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function boomerang(){
      return $this->hasOne('App\Models\tccws\TRemesa', 'rms_remesapadre');
    }

    public function facturas(){
      return $this->hasMany('App\Models\tccws\TFactsxremesa', 'fxr_remesa', 'id');
    }

    public function nombreCliente(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'rms_terceroid');
    }

}
