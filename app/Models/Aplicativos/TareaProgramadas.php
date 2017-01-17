<?php

namespace App\Models\Aplicativos;

use Illuminate\Database\Eloquent\Model;

class TareaProgramadas extends Model
{
    protected $connection = 'aplicativos';

    protected $table = 't_tareaprogramadas';

    protected $primaryKey = 'idTarea';

    public $timestamps = false;

    protected $fillable = [
        'tar_int_consecutivo',
        'tar_int_grupo',
        'tar_int_grupoorden',
        'tar_txt_nombrebd',
        'tar_txt_hora',
        'tar_txt_dia',
        'tar_txt_mes',
        'tar_txt_diasemana',
        'tar_txt_nombrearchivo',
        'tar_txt_descripcion',
        'tar_int_id_notificacion',
        'tar_txt_estado',
    ];
}
