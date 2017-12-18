<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TLogTareasprogramada
 */
class TLogTareasprogramada extends Model
{
    protected $table = 't_log_tareasprogramadas';

    protected $primaryKey = 'lgt_id';

	public $timestamps = false;

    protected $fillable = [
        'lgt_tarea',
        'lgt_registro',
        'lgt_fecha'
    ];

    protected $guarded = [];

        
}