<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TCriteriosItem extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_criterios_item';

    protected $fillable = [
        'cri_plan',
        'cri_col_unoe',
        'cri_col_item',
        'cri_regular',
        'cri_estuche',
        'cri_oferta'
    ];

    public function planes()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriterioplan', 'idCriterioPlan', 'cri_plan');
  	}
}
