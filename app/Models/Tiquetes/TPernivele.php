<?php

namespace App\Models\tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPernivele
 */
class TPernivele extends Model
{
    protected $table = 't_perniveles';

    public $timestamps = true;

    protected $fillable = [
        'pen_usuario',
        'pen_nombre',
        'pen_cedula',
        'pen_idtipoper',
        'pen_nomnivel',
        'pen_idterritorios'
    ];

    protected $guarded = [];


}
