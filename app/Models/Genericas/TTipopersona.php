<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipopersona
 */
class TTipopersona extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_tipopersona';

    public $timestamps = false;

    protected $fillable = [
        'tpp_descripcion',
        'tpp_estado'
    ];

    protected $guarded = [];


}
