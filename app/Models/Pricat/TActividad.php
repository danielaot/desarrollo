<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TActividad extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_actividades';

    protected $fillable = [
        'act_titulo',
        'act_descripcion',
        'act_proc_id',
        'act_ar_id',
        'act_plantilla',
        'act_confirmarerp'
    ];

    public function predecesoras()
  	{
  		  return $this->hasMany('App\Models\Pricat\TPredecesora', 'pre_act_id');
  	}

    public function areas()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TArea', 'act_ar_id');
  	}

    public function procesos()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TProceso', 'act_proc_id');
  	}

    public function desarrollos()
  	{
  		  return $this->hasMany('App\Models\Pricat\TDesarrolloActividad', 'dac_act_id');
  	}

    public function notiactividad()
    {
      		return $this->hasMany('App\Models\Pricat\TNotiActividad','not_actividad', 'id');
    }
}
