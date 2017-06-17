<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TRegsanGranel extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_regsan_granel';

    protected $fillable = [
        'rsg_not_san',
        'rsg_ref_granel'
    ];

    public function notificaciones()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TNotificacionSanitaria', 'rsg_not_san');
  	}
}
