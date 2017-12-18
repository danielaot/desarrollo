<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TMotsalida
 */
class TMotsalida extends Model
{
    protected $table = 't_motsalida';

    protected $primaryKey = 'mts_id';

	public $timestamps = false;

    protected $fillable = [
        'mts_concepto',
        'mts_motivo',
        'mts_centrocosto',
        'mts_estado'
    ];

    protected $guarded = [];

        
}