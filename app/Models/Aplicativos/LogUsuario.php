<?php

namespace App\Models\Aplicativos;

use Illuminate\Database\Eloquent\Model;

class LogUsuario extends Model
{
    protected $connection = 'aplicativos';

    protected $table = 't_logusuario';

    protected $primaryKey = 'log_id';

    public $timestamps = false;

    protected $fillable = [
        'usu_id',
        'log_num_creacion',
        'log_txt_ip',
        'log_txt_url',
        'log_num_tipo',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Aplicativos\User','usu_id','login');
    }
}
