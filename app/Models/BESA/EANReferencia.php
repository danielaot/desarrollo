<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class EANReferencia extends Model
{
    protected $connection = 'besa';

    protected $table = '000_EANReferencia';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'EAN',
        'Referencia',
        'Descripcion'
    ];
}
