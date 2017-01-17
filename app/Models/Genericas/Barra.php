<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class Barra extends Model
{
    protected $connection = 'genericas';

    protected $table = 'barra';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'idBarra',
        'idItemBarra',
        'cantidadItem',
        'unidadMedidaItem',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Genericas\Item','idItemBarra','idItem');
    }
}
