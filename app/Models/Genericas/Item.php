<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'genericas';

    protected $table = 'item';

    protected $primaryKey = 'idItem';

    public $incrementing = false;

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

    public function barra()
    {
        return $this->hasOne('App\Models\Genericas\Barra','idItemBarra','idItem');
    }
}
