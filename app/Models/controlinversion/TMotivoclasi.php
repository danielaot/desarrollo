<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TMotivoclasi
 */
class TMotivoclasi extends Model
{
    protected $table = 't_motivoclasi';

    protected $primaryKey = 'mtv_id';

	public $timestamps = false;

    protected $fillable = [
        'mtv_clasificacion',
        'mtv_motivo'
    ];

    protected $guarded = [];

        
}