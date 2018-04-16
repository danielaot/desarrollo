<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TClienteSegmento extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_cliente_segmentos';

    protected $fillable = [
        'cls_cliente',
        'cls_segmento'
    ];

    public function clientes()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TCliente', 'cls_cliente');
  	}

    public function segmentos()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TCampSegmento', 'cls_segmento');
  	}
}
