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

    public function boomerang(){
        return $this->hasOne('App\Models\tccws\TClientesBoomerang', 'clb_idTercero', 'idTercero');
    }

    public function tclientetcc(){
        return $this->hasOne('App\Models\Genericas\TCliente', 'ter_id', 'idTercero');
    }

    public function usuario(){
        return $this->hasOne('App\Models\aplicativos\User', 'idTerceroUsuario', 'idTercero');
    }

    public function dirnacional(){
        return $this->hasOne('App\Models\Genericas\TDirNacional', 'dir_txt_cedula', 'idTercero');
    }

    public function personanivel(){
        return $this->hasOne('App\Models\Tiquetes\TPernivele', 'pen_cedula', 'idTercero');
    }

    public function persona(){
        return $this->hasOne('App\Models\Tiquetes\TPersona', 'perTxtCedtercero', 'idTercero');
    }

}
