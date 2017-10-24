<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TMarca extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_marcas';

    protected $fillable = [
        'mar_nombre',
        'mar_linea'
    ];

    public function lineas()
  	{
  		  return $this->hasMany('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'mar_linea');
  	}
}
