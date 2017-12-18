<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolifactura
 */
class TSolifactura extends Model
{
    protected $table = 't_solifactura';

    protected $primaryKey = 'sof_id';

	public $timestamps = false;

    protected $fillable = [
        'sof_sci_id',
        'sof_factura',
        'sof_fechafactura',
        'sof_valor',
        'sof_usuario',
        'sof_fecha'
    ];

    protected $guarded = [];

        
}