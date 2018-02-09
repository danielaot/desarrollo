<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TAerolinea
 */
class TEstados extends Model
{
	protected $connection = 'tiqueteshotel';
	
    protected $table = 't_estados';

	public $timestamps = false;

    protected $fillable = [
        'estIntEstado',
        'estTxtNombre'
    ];

    protected $guarded = [];


}
