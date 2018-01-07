<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class THotel
 */
class THotel extends Model
{
    protected $table = 't_hotel';

    protected $primaryKey = 'hotIntId';

	public $timestamps = false;

    protected $fillable = [
        'hotTxtNombre',
        'hotIntCiu',
        'hotTxtDireccion',
        'hotTxtTelefono',
        'hotTxtEstado'
    ];

    protected $guarded = [];


}
