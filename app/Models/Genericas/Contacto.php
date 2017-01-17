<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $connection = 'genericas';

    protected $table = 'contacto';

    protected $primaryKey = 'idContacto';

    public $timestamps = false;

    protected $fillable = [
        'idEmpresaContacto',
        'nombreContacto',
        'direccionContacto',
        'idPaisContacto',
        'idDepartamentoContacto',
        'idCiudadContacto',
        'barrioContacto',
        'telefonoContacto',
        'emailContacto',
    ];
}
