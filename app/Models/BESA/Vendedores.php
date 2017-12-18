<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class Vendedores extends Model
{
    protected $connection = 'besa';

    protected $table = '203_Vendedores';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
          'CodVendedor',
          'IdVendedor',
          'NitVendedor',
          'NomVendedor'
    ];
}
