<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCiudade
 */
class TCiudade extends Model
{
    protected $connection = 'tiqueteshotel';

    protected $table = 't_ciudades';

    protected $primaryKey = 'idCiudades';

	public $timestamps = false;

    protected $fillable = [
        'Paises_Codigo',
        'Ciudad'
    ];

    public function ciudades(){

      return $this->belongsTo('App\Models\Tiquetes\TPaises','Paises_Codigo','Codigo');
    }


}
