<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolifacturaconp
 */
class TSolifacturaconp extends Model
{
    protected $table = 't_solifacturaconp';

    protected $primaryKey = 'sfc_id';

	public $timestamps = false;

    protected $fillable = [
        'sfc_sof_id',
        'sfc_cos_id',
        'sfc_cantidad',
        'sfc_valor'
    ];

    protected $guarded = [];

        
}