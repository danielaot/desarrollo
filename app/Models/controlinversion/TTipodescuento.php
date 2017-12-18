<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipodescuento
 */
class TTipodescuento extends Model
{
    protected $table = 't_tipodescuento';

    protected $primaryKey = 'tdc_id';

	public $timestamps = false;

    protected $fillable = [
        'tdc_descripcion',
        'tdc_valordefecto',
        'tdc_cuenta',
        'tdc_estado'
    ];

    protected $guarded = [];

        
}