<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNiveles
 */
class TNiveles extends Model
{
	protected $connection = 'bd_controlinversion';

    protected $table = 't_niveles';

	public $timestamps = true;

    protected $fillable = [
        'niv_nombre',
        'niv_idpadre'
    ];

    protected $guarded = [];

        
}