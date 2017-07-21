<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class EANReferenciaEAN14 extends Model
{
    protected $connection = 'besa';

    protected $table = '000_EANReferencia_EAN14';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'EAN',
        'Referencia',
        'Descripcion'
    ];
}
