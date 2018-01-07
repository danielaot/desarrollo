<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPaises
 */
class TPaises extends Model
{
    protected $connection = 'tiqueteshotel';

    protected $table = 't_paises';

    protected $primaryKey = 'Codigo';

    public $incrementing = false;

	  public $timestamps = false;

    protected $fillable = [
        'Pais'
    ];

    protected $guarded = [];

    public function ciudades(){
      return $this->hasMany('App\Models\Tiquetes\TCiudade', 'Paises_Codigo', 'Codigo');
    }

}
