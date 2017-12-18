<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TFacturara
 */
class TFacturara extends Model
{
	protected $connection = 'bd_controlinversion';
    protected $table = 't_facturara';
    protected $primaryKey = 'fca_id';
	public $timestamps = false;
    protected $fillable = [
        'fca_idTercero',
        'fca_clasificacion',
        'fca_estado'
    ];
    protected $guarded = [];

    public function tercero () {
    	return $this->hasOne('App\Models\Genericas\Tercero','nitTercero','fca_idTercero');
    }

}