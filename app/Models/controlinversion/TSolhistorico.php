<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolhistorico
 */
class TSolhistorico extends Model
{
    protected $connection = "bd_controlinversion";

    protected $table = 't_solhistorico';

    protected $primaryKey = 'soh_id';

	public $timestamps = false;

    protected $fillable = [
        'soh_sci_id',
        'soh_soe_id',
        'soh_idTercero_envia',
        'soh_idTercero_recibe',
        'soh_observacion',
        'soh_fechaenvio',
        'soh_estadoenvio'
    ];

    protected $guarded = [];

    public function solicitud(){
      return $this->hasOne('App\Models\controlinversion\TSolicitudctlinv', 'sci_id', 'soh_sci_id');
    }

    public function estado(){
      return $this->hasOne('App\Models\controlinversion\TSolestado', 'soe_id', 'soh_soe_id');
    }

    public function perNivelEnvia(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'soh_idTercero_envia');
    }

    public function perNivelRecibe(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'soh_idTercero_recibe');
    }

}
