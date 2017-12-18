<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TNiveles
 */
class TPerniveles extends Model
{
    use SoftDeletes;

	protected $connection = 'bd_controlinversion';

    protected $table = 't_perniveles';

	public $timestamps = true;

    protected $fillable = [
        'pern_usuario',
        'pern_nombre',
        'pern_cedula',
        'pern_tipopersona',
        'pern_jefe',
        'pern_nomnivel'
    ];

    protected $dates = ['deleted_at'];


    public function children()
    {
        return $this->belongsTo('App\Models\controlinversion\TPerniveles','pern_jefe');
    }
	
    public function tperjefe(){
		return $this->hasOne('App\Models\controlinversion\TPerniveles', 'id', 'pern_jefe');
	}

    public function canales(){
        return $this->hasMany('App\Models\controlinversion\TCanalpernivel', 'cap_idpernivel', 'id');
    }
    
}
