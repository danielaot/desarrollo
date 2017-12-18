<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRutaaprobacion
 */
class TRutaaprobacion extends Model
{
    protected $table = 't_rutaaprobacion';

    protected $primaryKey = 'rua_id';

	public $timestamps = false;

    protected $fillable = [
        'rua_sci_id',
        'rua_nva_tipo',
        'rua_orden',
        'rua_fecha',
        'rua_aprobada',
        'rua_orden_tipo'
    ];

    protected $guarded = [];

        
}