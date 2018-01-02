<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class Tercero extends Model
{
    protected $connection = 'genericas';

    protected $table = 'tercero';

    protected $primaryKey = 'idRowTercero';

	  public $timestamps = false;

    protected $fillable = [
        'idTercero',
        'nitTercero',
        'dvNitTercero',
        'tipoIdentTercero',
        'razonSocialTercero',
        'apellido1Tercero',
        'apellido2Tercero',
        'nombreTercero',
        'idContactoTercero',
        'indxClienteTercero',
        'indxProveedorTercero',
        'indxEmpleadoTercero',
        'indxAccionistaTercero',
        'indxInternoTercero',
        'indxOtroTercero',
        'nombreEstablecimientoTercero',
        'fechaNacimientoTercero',
        'indxEstadoTercero'
    ];

}
