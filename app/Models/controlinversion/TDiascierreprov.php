<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDiascierreprov
 */
class TDiascierreprov extends Model
{
    protected $table = 't_diascierreprov';

    protected $primaryKey = 'dcp_id';

	public $timestamps = false;

    protected $fillable = [
        'dcp_dias',
        'dcp_estado'
    ];

    protected $guarded = [];

        
}