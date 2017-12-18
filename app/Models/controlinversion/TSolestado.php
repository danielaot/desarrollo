<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolestado
 */
class TSolestado extends Model
{
    protected $connection = "bd_controlinversion";

    protected $table = 't_solestado';

    protected $primaryKey = 'soe_id';

	public $timestamps = false;

    protected $fillable = [
        'soe_descripcion',
        'soe_estado'
    ];

    protected $guarded = [];

        
}