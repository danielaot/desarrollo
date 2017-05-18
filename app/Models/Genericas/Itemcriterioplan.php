<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class Itemcriterioplan extends Model
{
    protected $connection = 'genericas';

    protected $table = 'itemcriterioplan';

    protected $primaryKey = 'idCriterioPlan';

	  public $timestamps = false;

    protected $fillable = [
        'idEmpresa',
        'nombreCriterioPlan'
    ];

    public function criterios()
  	{
  		  return $this->hasMany('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioPlanItemCriterioMayor', 'idCriterioPlan');
  	}
}
