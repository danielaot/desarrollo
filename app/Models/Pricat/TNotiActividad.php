<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TNotiActividad extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_notiactividad';

    protected $fillable = [
        'not_usuario',
        'not_actividad'
    ];

    public function actividades()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TActividad', 'not_actividad');
  	}

    public function usuarios()
  	{
  		  return $this->belongsTo('App\Models\Genericas\TDirNacional', 'not_usuario', 'dir_txt_cedula');
  	}

}
