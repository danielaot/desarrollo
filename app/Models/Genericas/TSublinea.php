<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TSublinea extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_sublinea';

    protected $primaryKey = 'subl_int_idunoe';

    public $timestamps = false;

    protected $fillable = [
        'subl_txt_nombre'
    ];
}
