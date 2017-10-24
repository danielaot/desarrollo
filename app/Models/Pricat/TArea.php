<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TArea extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_areas';

    protected $fillable = [
        'ar_nombre',
        'ar_descripcion'
    ];

    public function actividades()
  	{
  		  return $this->hasMany('App\Models\Pricat\TActividad', 'act_ar_id');
  	}

    public function responsables()
  	{
  		  return $this->hasMany('App\Models\Pricat\TResponsable', 'res_ar_id');
  	}

}
