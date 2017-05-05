<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TNotificacion extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_notificaciones';

    protected $fillable = [
        'not_usuario',
        'not_act_id'
    ];

    public function actividades()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TActividad', 'not_act_id');
  	}

    public function usuarios()
  	{
  		  return $this->belongsTo('App\Models\Genericas\TDirNacional', 'not_usuario', 'dir_txt_cedula');
  	}

}
