<?php

namespace App\Models\tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNivele
 */
class TNivele extends Model
{
	protected $connection = 'tiqueteshotel';
	
    protected $table = 't_niveles';

    public $timestamps = true;

    protected $fillable = [
        'niv_descripcion'
    ];

    protected $guarded = [];


}
