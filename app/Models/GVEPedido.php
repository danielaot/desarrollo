<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GVEPedido extends Model
{
    protected $connection = 'generarventaempleado';

    protected $table = 't_pedido';

    protected $primaryKey = 'ped_id';

    public $timestamps = false;

    protected $fillable = [
        'ped_nitclient',
        'ped_fechaorden',
        'ped_usuario',
        'ped_estadopedido',
    ];

    public function pedidodetalle()
    {
        return $this->hasMany('App\Models\GVEPedidoDetalle','det_idpedido','ped_id');
    }
}
