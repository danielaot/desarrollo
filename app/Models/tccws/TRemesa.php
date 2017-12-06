<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRemesa
 */
class TRemesa extends Model
{
    protected $connection = 'conectortccws';

    protected $table = 't_remesas';

    public $timestamps = true;

    protected $fillable = [
        'rms_remesa',
        'rms_cajas',
        'rms_lios',
        'rms_pesolios',
        'rms_palets',
        'rms_pesopalets',
        'rms_pesototal',
        'rms_remesapadre',
        'rms_isBoomerang'
    ];

    protected $guarded = [];

    public function boomerang(){
      return $this->hasOne('App\Models\tccws\TRemesa', 'rms_remesapadre');
    }

    public function facturas(){
      return $this->hasMany('App\Models\tccws\TFactsxremesa', 'fxr_remesa', 'id');
    }


}
