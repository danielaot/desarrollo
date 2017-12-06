<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TAsignacionfactura
 */
class TAsignacionfactura extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_asignacionfacturas';

    protected $primaryKey = 'asi_id';

	public $timestamps = false;

    protected $fillable = [
        'asi_dat_fecha',
        'asi_num_facrecibidas',
        'asi_num_facdespachos'
    ];

    protected $guarded = [];


}
