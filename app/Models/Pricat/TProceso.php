<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TProceso extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_procesos';

    protected $fillable = [
        'pro_nombre',
        'pro_descripcion'
    ];

    public function actividades()
  	{
  		  return $this->hasMany('App\Models\Pricat\TActividad', 'act_proc_id');
  	}

    public function proyectos()
  	{
  		  return $this->hasMany('App\Models\Pricat\TActividad', 'proy_proc_id');
  	}

}
