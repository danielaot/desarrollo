<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicliente
 */
class TSolicliente extends Model
{

    protected $connection = "bd_controlinversion";

    protected $table = 't_solicliente';

    protected $primaryKey = 'scl_id';

	  public $timestamps = false;

    protected $fillable = [
        'scl_sci_id',
        'scl_cli_id',
        'scl_nombre',
        'scl_ventaesperada',
        'scl_desestimado',
        'scl_por',
        'scl_estado'
    ];

    protected $guarded = [];

    public function clientesZonas(){
      return $this->hasOne('App\Models\controlinversion\TSoliclientezona', 'scz_scl_id', 'scl_id');
    }

    public function clientesReferencias(){
      return $this->hasMany('App\Models\controlinversion\TSolireferencium', 'srf_scl_id', 'scl_id');
    }

}
