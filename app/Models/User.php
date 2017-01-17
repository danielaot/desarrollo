<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'aplicativos';

    protected $table = 'usuario';

    protected $primaryKey = 'login';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'password',
        'nombre',
        'apellido',
        'tipoUsuario',
        'fechaRegistro',
        'fechaIngreso',
        'idTerceroUsuario',
        'numactivo',
    ];

    protected $hidden = [
        'password',
    ];

    public function dirnacional()
    {
        return $this->hasOne('App\Models\GDirNacional','dir_txt_cedula','idTerceroUsuario');
    }
}
