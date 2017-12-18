<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicanale
 */
class TSolicanale extends Model
{
    protected $table = 't_solicanales';

    protected $primaryKey = 'cns_id';

	public $timestamps = false;

    protected $fillable = [
        'cns_sci_id',
        'cns_can_id',
        'cns_porcentaje',
        'cns_estado'
    ];

    protected $guarded = [];

        
}