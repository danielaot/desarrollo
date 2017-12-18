<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPresupuesto
 */
class TPresupuesto extends Model
{
    protected $table = 't_presupuesto';

    protected $primaryKey = 'psr_id';

	public $timestamps = false;

    protected $fillable = [
        'psr_lin_id',
        'psr_anio',
        'psr_estado'
    ];

    protected $guarded = [];

        
}