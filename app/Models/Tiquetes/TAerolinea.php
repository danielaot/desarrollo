<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TAerolinea
 */
class TAerolinea extends Model
{
    protected $table = 't_aerolinea';

    protected $primaryKey = 'aerIntId';

	public $timestamps = false;

    protected $fillable = [
        'aerTxtNombre',
        'aerTxtEstado'
    ];

    protected $guarded = [];


}
