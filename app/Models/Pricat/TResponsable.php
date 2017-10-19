<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TResponsable extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_responsables';

    protected $fillable = [
        'res_usuario',
        'res_ar_id'
    ];

    public function areas()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TArea', 'res_ar_id');
  	}

    public function usuarios()
  	{
  		  return $this->belongsTo('App\Models\Genericas\TDirNacional', 'res_usuario', 'dir_txt_cedula');
  	}

}
