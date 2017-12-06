<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRangoremesa
 */
class TRangoremesa extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_rangoremesa';

    protected $primaryKey = 'rrm_id_rango';

	public $timestamps = false;

    protected $fillable = [
        'rrm_num_activo',
        'rrm_num_rangoinicio',
        'rrm_num_rangofin',
        'rrm_num_creacion',
        'rrm_num_cuentaremite'
    ];

    protected $guarded = [];


}
