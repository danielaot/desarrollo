<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDetnovremesa
 */
class TDetnovremesa extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_detnovremesa';

    protected $primaryKey = 'det_id';

	public $timestamps = false;

    protected $fillable = [
        'rem_id',
        'nov_id',
        'det_num_desde',
        'det_ltxt_observacion'
    ];

    protected $guarded = [];


}
