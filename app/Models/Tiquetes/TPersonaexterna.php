<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPersonaexterna
 */
class TPersonaexterna extends Model
{
    protected $connection = 'tiqueteshotel';
    
    protected $table = 't_personaexterna';

    protected $primaryKey = 'pereIntSolId';

	public $timestamps = false;

    protected $fillable = [
        'pereTxtCedula',
        'pereTxtFNacimiento',
        'pereTxtNumCelular',
        'pereTxtNombComple',
        'pereTxtEmail'
    ];

    protected $guarded = [];


}
