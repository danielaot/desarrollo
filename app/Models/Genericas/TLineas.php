<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TLineas extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_lineas';

    protected $primaryKey = 'lin_id';

    public $timestamps = false;

    protected $fillable = [
        'cat_id',
        'lin_txt_descrip',
        'lin_txt_estado'
    ];
}
