<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TLog
 */
class TLog extends Model
{
    protected $table = 't_log';

    protected $primaryKey = 'log_id';

	public $timestamps = false;

    protected $fillable = [
        'log_tabla',
        'log_operacion',
        'log_valoresantes',
        'log_valoresdespues',
        'log_formulario',
        'log_idregistro',
        'log_usuario',
        'log_fecha'
    ];

    protected $guarded = [];

        
}