<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class Itemcriteriomayor extends Model
{
    protected $connection = 'genericas';

    protected $table = 'itemcriteriomayor';

    public $timestamps = false;

    protected $fillable = [
        'idEmpresaItemCriterioMayor',
        'idItemCriterioPlanItemCriterioMayor',
        'idItemCriterioMayor',
        'descripcionItemCriterioMayor',
        'notaItemCriterioMayor'
    ];

    public function planes()
  	{
  		  return $this->belongsTo('App\Models\Genericas\Itemcriterioplan', 'idItemCriterioPlanItemCriterioMayor', 'idCriterioPlan');
  	}

    public function marcas()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TMarca', 'idItemCriterioMayor', 'mar_linea');
  	}

    public function categorias()
  	{
  		  return $this->belongsTo('App\Models\Genericas\TLineas', 'idItemCriterioMayor', 'lin_id');
  	}
}
