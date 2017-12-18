<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TLineascc
 */
class TLineascc extends Model
{
	protected $connection = 'bd_controlinversion';
	
    protected $table = 't_lineascc';

    protected $primaryKey = 'lcc_id';

	public $timestamps = false;

    protected $fillable = [
        'lcc_codigo',
        'lcc_centrocosto',
        'lcc_estado'
    ];

    protected $guarded = [];

    public function LineasProducto()
    {
        return $this->hasOne('App\Models\BESA\LineasProducto', 'CodLinea', 'lcc_codigo');

    }    

        
}