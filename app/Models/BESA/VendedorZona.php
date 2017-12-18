<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class VendedorZona extends Model
{
    protected $connection = 'besa';

    protected $table = 'VendedorZona_tmp';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'CodVendedor',
        'NitVendedor',
        'NomVendedor',
        'CodZona',
        'NomZona',
        'CodSubZona',
        'NomSubZona',
        'CodSubZona_ant',
        'NomSubZona_ant',
        'dir_territorio',
        'ger_zona'
    ];

}
