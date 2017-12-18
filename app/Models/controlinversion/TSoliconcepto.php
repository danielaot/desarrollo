<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliconcepto
 */
class TSoliconcepto extends Model
{
    protected $table = 't_soliconceptos';

    protected $primaryKey = 'cos_id';

	public $timestamps = false;

    protected $fillable = [
        'cos_sci_id',
        'cos_cgr_id',
        'cos_concepto',
        'cos_cantidad',
        'cos_valor',
        'cos_estado'
    ];

    protected $guarded = [];

        
}