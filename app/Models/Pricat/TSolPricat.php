<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TSolPricat extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_sol_pricat';

    protected $fillable = [
        'sop_cliente',
        'sop_kam',
        'sop_tnovedad',
        'sop_fecha_inicio',
        'sop_fecha_fin',
        'sop_estado'
    ];

    public function detalles()
  	{
  		  return $this->hasMany('App\Models\Pricat\TSolPricatDetalle', 'spd_sol');
  	}

    public function clientes()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TCliente', 'sop_cliente');
  	}
}
