<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TPredecesora extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_predecesoras';

    protected $fillable = [
        'pre_act_id',
        'pre_act_pre_id'
    ];

    public function actividades()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TActividad', 'pre_act_id');
  	}

    public function actividadespre()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TActividad', 'pre_act_pre_id');
  	}
}
