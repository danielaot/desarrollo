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

    public function Cliente()
    {
        return $this->hasOne('App\Models\Genericas\TCliente', 'ter_id', 'idTercero');
    }

    public function usuario(){
        return $this->hasOne('App\Models\aplicativos\User', 'idTerceroUsuario', 'idTercero');
    }

}
