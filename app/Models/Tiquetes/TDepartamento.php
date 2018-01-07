<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDepartamento
 */
class TDepartamento extends Model
{
    protected $table = 't_departamento';

    protected $primaryKey = 'depIntId';

	public $timestamps = false;

    protected $fillable = [
        'depIntIdPais',
        'depIntCod',
        'depTxtNom',
        'depTxtEstado'
    ];

    protected $guarded = [];


}
