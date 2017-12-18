<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolireferencium
 */
class TSolireferencium extends Model
{

    protected $connection = "bd_controlinversion";

    protected $table = 't_solireferencia';

    protected $primaryKey = 'srf_id';

	public $timestamps = false;

    protected $fillable = [
        'srf_scl_id',
        'srf_referencia',
        'srf_lin_id_gasto',
        'srf_estadoref',
        'srf_preciouni',
        'srf_unidades',
        'srf_porcentaje',
        'srf_estado'
    ];

    protected $guarded = [];

    public function LineaProducto(){
      return $this->hasOne('App\Models\controlinversion\TLineascc', 'lcc_codigo', 'srf_lin_id_gasto');
    }

    public function referencia(){
      return $this->hasOne('App\Models\Genericas\TItemCriteriosTodo', 'ite_referencia', 'srf_referencia');
    }


}
