<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TNotificacionSanitaria extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_notificacion_sanitaria';

    protected $fillable = [
        'nosa_nombre',
        'nosa_notificacion',
        'nosa_fecha_inicio',
        'nosa_fecha_vencimiento',
        'nosa_documento'
    ];

    public function graneles()
  	{
  		  return $this->hasMany('App\Models\Pricat\TRegsanGranel', 'rsg_not_san');
  	}
}
