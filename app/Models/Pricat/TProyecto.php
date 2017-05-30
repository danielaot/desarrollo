<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TProyecto extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_proyectos';

    protected $fillable = [
        'proy_nombre',
        'proy_estado',
        'proy_proc_id'
    ];

    public function desarrollos()
    {
        return $this->hasMany('App\Models\Pricat\TDesarrolloActividad','dac_proy_id');
    }

    public function procesos()
    {
        return $this->belongsTo('App\Models\Pricat\TProceso','proy_proc_id');
    }

    public function items()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TItem', 'ite_proy');
  	}

}
