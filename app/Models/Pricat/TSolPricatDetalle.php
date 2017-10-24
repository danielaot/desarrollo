<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TSolPricatDetalle extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_sol_pricat_detalle';

    protected $fillable = [
        'spd_sol',
        'spd_referencia',
        'spd_preciobruto',
        'spd_preciosugerido'
    ];

    public function solicitudes()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TSolPricat', 'spd_sol');
  	}

    public function items()
  	{
  		  return $this->hasOne('App\Models\Pricat\TItem', 'ite_referencia', 'spd_referencia');
  	}
}
