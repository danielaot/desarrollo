<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoinventario
 */
class TTipoinventario extends Model
{
    protected $table = 't_tipoinventario';

    protected $primaryKey = 'tin_id';

	public $timestamps = false;

    protected $fillable = [
        'tin_codtipoinv',
        'tin_estado'
    ];

    protected $guarded = [];

        
}