<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TCliente extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_clientes';

    protected $fillable = [
        'cli_nit',
        'cli_codificacion',
        'cli_modificacion',
        'cli_eliminacion',
        'cli_kam',
        'cli_gln'
    ];

    public function segmentos()
  	{
  		  return $this->hasMany('App\Models\Pricat\TClienteSegmento', 'cls_cliente');
  	}

    public function solicitudes()
  	{
  		  return $this->hasMany('App\Models\Pricat\TSolPricat', 'sop_cliente');
  	}

    public function terceros()
  	{
  		  return $this->hasOne('App\Models\Genericas\Tercero', 'nitTercero', 'cli_nit');
  	}
}
