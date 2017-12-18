<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoorden
 */
class TTipopersona extends Model
{
	protected $connection = 'bd_controlinversion';
    protected $table = 't_tipopersona';
    protected $primaryKey = 'tpe_id';
	public $timestamps = false;
    protected $fillable = [
        'tpe_tipopersona',
        'tpe_estado'
    ];

    protected $guarded = [];

        
}