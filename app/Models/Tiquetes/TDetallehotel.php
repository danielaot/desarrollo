<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDetallehotel
 */
class TDetallehotel extends Model
{
    protected $connection = 'tiqueteshotel';
    
    protected $table = 't_detallehotel';

    protected $primaryKey = 'dthIntId';

	public $timestamps = false;

    protected $fillable = [
        'dthIntIdHotel',
        'dthIntDias',
        'dthIntCosto',
        'dthTxtReserva',
        'dthIntIdDetasoli'
    ];

    protected $guarded = [];


}
