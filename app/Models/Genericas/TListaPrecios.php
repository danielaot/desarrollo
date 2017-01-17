<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TListaPrecios extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_listaprecios';

    protected $primaryKey = 'lis_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'lis_txt_descrip',
        'lis_txt_moneda'
    ];
}
