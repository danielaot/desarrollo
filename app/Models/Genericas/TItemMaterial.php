<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TItemMaterial extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_itemmaterial';

    public $timestamps = false;

    protected $fillable = [
        'ite_padre_id',
        'ite_hijo_id',
        'ite_txt_referencia',
        'ite_txt_descripcion',
        'ite_num_cantreq',
        'ite_txt_tipoinventario'
    ];
}
