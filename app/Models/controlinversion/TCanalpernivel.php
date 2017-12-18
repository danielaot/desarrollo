<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNiveles
 */
class TCanalpernivel extends Model
{
	protected $connection = 'bd_controlinversion';

    protected $table = 't_canalpernivel';

	public $timestamps = true;

    protected $fillable = [
        'cap_idcanal',
        'cap_idpernivel', 
        'cap_idlinea'
    ];

        
}