<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPresupuestodetum
 */
class TPresupuestodetum extends Model
{
    protected $table = 't_presupuestodeta';

    protected $primaryKey = 'prd_id';

	public $timestamps = false;

    protected $fillable = [
        'prd_psr_id',
        'prd_tib_id',
        'prd_periodo',
        'prd_valorpres',
        'prd_estado'
    ];

    protected $guarded = [];

        
}