<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCentroOperaciones extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_centrooperaciones';

    protected $primaryKey = 'cen_id';

    public $timestamps = false;

    protected $fillable = [
        'cen_txt_descripcion',
    ];
}
