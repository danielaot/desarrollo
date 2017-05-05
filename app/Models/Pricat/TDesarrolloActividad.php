<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TDesarrolloActividad extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_desarrollo_actividades';

    protected $fillable = [
        'dac_proy_id',
        'dac_act_id',
        'dac_fecha_inicio',
        'dac_fecha_final',
        'dac_fecha_cumplimiento',
        'dac_usuario',
        'dac_observacion',
        'dac_estado'
    ];

    public function actividades()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TActividad', 'dac_act_id');
  	}

    public function usuarios()
  	{
  		  return $this->belongsTo('App\Models\Genericas\TDirNacional', 'dac_usuario', 'dir_txt_cedula');
  	}

    public function proyectos()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TProyecto', 'dac_proy_id');
  	}

}
