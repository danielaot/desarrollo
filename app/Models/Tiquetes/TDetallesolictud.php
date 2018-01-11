<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDetallesolictud
 */
class TDetallesolictud extends Model
{
    protected $connection = 'tiqueteshotel';

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

    public function detalle(){
      return $this->hasMany('App\Models\Tiquetes\TSolicitud', 'dtaIntSolicitud', 'solIntSolId');
    }

}
