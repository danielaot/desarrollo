<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TDirNacional extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_directorionacional';

    protected $primaryKey = 'dir_id';

    public $timestamps = false;

    protected $fillable = [
        'dir_txt_cedula',
        'dir_txt_nombre',
        'dir_txt_area',
        'dir_txt_cargo',
        'dir_txt_email',
        'dir_txt_celular',
        'dir_txt_ciudad',
        'dir_txt_extension',
        'dir_txt_empresa',
        'dir_num_mostrar',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Aplicativos\User','dir_txt_cedula','idTerceroUsuario');
    }
}
