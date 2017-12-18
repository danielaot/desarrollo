<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTiposalida
 */
class TTiposalida extends Model
{
    
	protected $connection = 'bd_controlinversion';
	
    protected $table = 't_tiposalida';

    protected $primaryKey = 'tsd_id';

	public $timestamps = false;

    protected $fillable = [
        'tsd_descripcion',
        'tsd_codigo',
        'tsd_estado'
    ];

    protected $guarded = [];

        
}