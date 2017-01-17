<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GBarra extends Model
{
    protected $connection = 'genericas';

    protected $table = 'barra';

    protected $primaryKey = 'idBarra';

    public $timestamps = false;

    protected $fillable = [
        'idItemBarra',
        'cantidadItem',
        'unidadMedidaItem',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\GItem','idItemBarra','idItem');
    }
}
