<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TTipomedida extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_tipomedida';

    protected $primaryKey = 'tip_id';

    public $timestamps = false;

    protected $fillable = [
        'tip_txt_descripcion'
    ];
}
