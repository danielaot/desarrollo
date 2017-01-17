<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCentrosTrabajo extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_centrostrabajo';

    protected $primaryKey = 'cen_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'cen_txt_descripcion',
    ];
}
