<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoltipoinventario
 */
class TSoltipoinventario extends Model
{
    protected $table = 't_soltipoinventario';

    protected $primaryKey = 'ivs_id';

	public $timestamps = false;

    protected $fillable = [
        'ivs_sci_id',
        'ivs_tin_id',
        'ivs_estado'
    ];

    protected $guarded = [];

        
}