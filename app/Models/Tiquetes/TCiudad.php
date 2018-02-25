<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCiudad
 */
class TCiudad extends Model
{
    protected $connection = 'tiqueteshotel';
    
    protected $table = 't_ciudad';

    protected $primaryKey = 'ciuIntId';

	public $timestamps = false;

    protected $fillable = [
        'ciuIntDep',
        'ciuTxtNom',
        'ciuIntCod',
        'ciuTxtEstado'
    ];

    protected $guarded = [];

    public function departamento(){
      return $this->hasOne('App\Models\Tiquetes\TDepartamento', 'depIntId', 'ciuIntDep');
    }
}
