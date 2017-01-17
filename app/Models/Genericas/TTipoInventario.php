<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TTipoInventario extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_tipoinventario';

    protected $primaryKey = 'tiin_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'tiin_txt_descripcion'
    ];
}
