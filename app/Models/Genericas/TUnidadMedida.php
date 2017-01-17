<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TUnidadMedida extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_unidadmedida';

    protected $primaryKey = 'und_id';

    public $timestamps = false;

    protected $fillable = [
        'und_txt_descripcion',
        'und_txt_abrpricat',
        'und_txt_abrinternaci',
        'tip_id'
    ];
}
