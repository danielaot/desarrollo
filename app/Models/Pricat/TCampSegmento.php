<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TCampSegmento extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_camp_segmentos';

    protected $fillable = [
        'cse_nombre',
        'cse_campo',
        'cse_segmento',
        'cse_orden',
        'cse_grupo',
        'cse_tnovedad'
    ];

    public function segmentos()
  	{
  		  return $this->hasMany('App\Models\Pricat\TClienteSegmento', 'cls_segmento');
  	}
}
