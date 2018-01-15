<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class tccwsTDoctoDespachostcc
 */
class TClientesBoomerang extends Model
{
    use SoftDeletes;

    protected $connection = 'conectortccws';

    protected $table = 't_cliboomerang';

    public $timestamps = true;

    protected $fillable = [
        'clb_idTercero',
        'clb_cod_sucursal',
        'clb_nom_tercero'
    ];

    protected $dates = ['deleted_at'];


    public function tercero(){
        return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'clb_idTercero');
    }
}