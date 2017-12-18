<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolisublinea
 */
class TSolisublinea extends Model
{
    protected $table = 't_solisublineas';

    protected $primaryKey = 'sbl_id';

	public $timestamps = false;

    protected $fillable = [
        'sbl_sln_id',
        'sbl_sublinea',
        'sbl_estado'
    ];

    protected $guarded = [];

        
}