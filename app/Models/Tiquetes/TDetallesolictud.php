<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDetallesolictud
 */
class TDetallesolictud extends Model
{
    protected $table = 't_detallesolictud';

    protected $primaryKey = 'dtaIntid';

	public $timestamps = false;

    protected $fillable = [
        'dtaIntOCiu',
        'dtaTxtOCiu',
        'dtaIntDCiu',
        'dtaTxtDCiudad',
        'dtaIntFechaVuelo',
        'dtaIntIdAerolinea',
        'dtaIntHoravuelo',
        'dtaTxtResvuelo',
        'dtaIntCostoVuelo',
        'dtaTxtFechaCompra',
        'dtaTxtHotel',
        'dtaIntSolicitud',
        'dtaIntCostoAdm',
        'dtaIntCostoIva'
    ];

    protected $guarded = [];


}
