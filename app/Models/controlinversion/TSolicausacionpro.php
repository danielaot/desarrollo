<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicausacionpro
 */
class TSolicausacionpro extends Model
{
    protected $table = 't_solicausacionpro';

    protected $primaryKey = 'scp_id';

	public $timestamps = false;

    protected $fillable = [
        'scp_sci_id',
        'scp_scl_id',
        'scp_prov',
        'scp_factura',
        'scp_fecha',
        'scp_valor',
        'scp_observacion',
        'scp_plano',
        'scp_planofecha',
        'scp_planoprovfecha',
        'scp_estado'
    ];

    protected $guarded = [];

        
}