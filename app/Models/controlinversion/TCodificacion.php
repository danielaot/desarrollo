<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCodificacion
 */
class TCodificacion extends Model
{
    protected $table = 't_codificacion';

    protected $primaryKey = 'cdf_id';

	public $timestamps = false;

    protected $fillable = [
        'cdf_ejecutivo',
        'cdf_cantidad'
    ];

    protected $guarded = [];

        
}