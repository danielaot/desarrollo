<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliclientezona
 */
class TSoliclientezona extends Model
{
    protected $connection = "bd_controlinversion";

    protected $table = 't_soliclientezona';

    protected $primaryKey = 'scz_id';

	public $timestamps = false;

    protected $fillable = [
        'scz_scl_id',
        'scz_zon_id',
        'scz_porcentaje',
        'scz_porcentaje_real',
        'scz_vdescuento',
        'scz_vesperado',
        'scz_estado'
    ];

    protected $guarded = [];


}
