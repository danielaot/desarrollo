<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GVEPedidoDetalle extends Model
{
    protected $connection = 'generarventaempleado';

    protected $table = 't_pedidodetalle';

    protected $primaryKey = 'det_id';

    public $timestamps = false;

    protected $fillable = [
        'det_idpedido',
        'det_referencia',
        'det_cantida',
        'det_valor',
        'det_usuariomov',
    ];

    public function pedido()
    {
        return $this->belongsTo('App\Models\GVEPedido','det_idpedido','ped_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\GItem','referenciaItem','det_referencia');
    }
}
