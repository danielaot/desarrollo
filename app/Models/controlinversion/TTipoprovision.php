<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoprovision
 */
class TTipoprovision extends Model
{
    protected $table = 't_tipoprovision';

    protected $primaryKey = 'tpv_id';

	public $timestamps = false;

    protected $fillable = [
        'tpv_descripcion',
        'tpv_estado'
    ];

    protected $guarded = [];

        
}