<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TCliente extends Model
{
    use SoftDeletes;

    protected $connection = 'pricat';

    protected $table = 't_clientes';

    protected $fillable = [
        'cli_nit',
        'cli_codificacion',
        'cli_modificacion',
        'cli_eliminacion',
        'cli_kam',
        'cli_gln',
        'cli_listaprecio'
    ];

    protected $dates = ['deleted_at'];

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

    public function kam()
    {
        return $this->hasOne('App\Models\Genericas\Tercero', 'nitTercero', 'cli_kam');
    }

    public function listaprecio()
    {
        return $this->hasOne('App\Models\BESA\AppwebListaPrecio', 'f112_id', 'cli_listaprecio');
    }
}
