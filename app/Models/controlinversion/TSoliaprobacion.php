<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliaprobacion
 */
class TSoliaprobacion extends Model
{
    protected $table = 't_soliaprobacion';

    protected $primaryKey = 'soa_id';

	public $timestamps = false;

    protected $fillable = [
        'soa_tiposol',
        'soa_tiponivel',
        'soa_activo',
        'soa_tope'
    ];

    protected $guarded = [];

        
}