<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TControlcorte
 */
class TControlcorte extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_controlcortes';

    protected $primaryKey = 'con_dat_generacion';

	public $timestamps = false;

    protected $fillable = [
        'con_num_corte'
    ];

    protected $guarded = [];


}
