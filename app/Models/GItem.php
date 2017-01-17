<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GItem extends Model
{
    protected $connection = 'genericas';

    protected $table = 'item';

    protected $primaryKey = 'idItem';

    public $timestamps = false;

    protected $fillable = [
        'idEmpresaItem',
        'id',
        'referenciaItem',
        'descripcionItem',
        'descripcionCortaItem',
        'unidadMedida',
        'idMovimientoEntidad',
    ];

    public function pedidodetalle()
    {
        return $this->belongsTo('App\Models\GVEPedidoDetalle','det_referencia','referenciaItem');
    }

    public function barra()
    {
        return $this->hasOne('App\Models\GBarra','idItemBarra','idItem');
    }
}
