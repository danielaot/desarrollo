<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicierrefec
 */
class TSolicierrefec extends Model
{
    protected $table = 't_solicierrefec';

    protected $primaryKey = 'scf_id';

	public $timestamps = false;

    protected $fillable = [
        'scf_sci_id',
        'scf_fecha',
        'scf_dias'
    ];

    protected $guarded = [];

        
}