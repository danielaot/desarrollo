<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TRechazos extends Model
{

  protected $connection = 'pricat';

  protected $table = 't_rechazos';

  protected $fillable = [
    'rec_id_act',
    'rec_observacion',
    'rec_id_proy'
  ];

    public function actividades()
    {
        return $this->belongsTo('App\Models\Pricat\TActividad', 'rec_id_act');
    }

    public  function proyecto (){

       return $this->hasOne('App\Models\Pricat\TDesarrolloActividad', 'dac_proy_id', 'rec_id_proy');
    }

}
