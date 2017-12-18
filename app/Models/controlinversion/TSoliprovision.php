<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliprovision
 */
class TSoliprovision extends Model
{
    protected $table = 't_soliprovision';

    protected $primaryKey = 'pro_id';

	public $timestamps = false;

    protected $fillable = [
        'pro_sci_id',
        'pro_tpv_id',
        'pro_nprovision',
        'pro_fecha_asignacion',
        'pro_cliente',
        'pro_zona',
        'pro_usuario',
        'pro_estado'
    ];

    protected $guarded = [];

        
}