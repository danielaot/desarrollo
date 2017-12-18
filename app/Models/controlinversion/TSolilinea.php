<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolilinea
 */
class TSolilinea extends Model
{
    protected $table = 't_solilinea';

    protected $primaryKey = 'sln_id';

	public $timestamps = false;

    protected $fillable = [
        'sln_sci_id',
        'sln_scz_id',
        'sln_lin_id',
        'sln_porcentaje',
        'sln_vesperada',
        'sln_vdescuento',
        'sln_estado'
    ];

    protected $guarded = [];

        
}