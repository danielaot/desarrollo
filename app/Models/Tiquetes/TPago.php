<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPago
 */
class TPago extends Model
{
    protected $table = 't_pago';

    protected $primaryKey = 'pagIntId';

	public $timestamps = false;

    protected $fillable = [
        'pagIntSolicitud',
        'pagTxtTipo',
        'pagTxtFactura',
        'pagIntFecha',
        'pagTxtCedProveedor',
        'pagTxtNomProveedor',
        'pagIntValorIni',
        'pagIntValorFin',
        'pagTxtObservacion'
    ];

    protected $guarded = [];


}
