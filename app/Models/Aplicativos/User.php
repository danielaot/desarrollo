<?php

namespace App\Models\Aplicativos;

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

    public function setRememberToken($value){}

    public function dirnacional()
    {
        return $this->hasOne('App\Models\Genericas\DirNacional','dir_txt_cedula','idTerceroUsuario');
    }

    public function logusuario()
    {
        return $this->hasMany('App\Models\Aplicativos\LogUsuario','usu_id','login');
    }

    public function nivelmenu()
    {
        return $this->hasMany('App\Models\Aplicativos\NivelMenuUsuario','usu_id','login');
    }
}
