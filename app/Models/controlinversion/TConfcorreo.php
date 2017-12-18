<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TConfcorreo
 */
class TConfcorreo extends Model
{
    protected $table = 't_confcorreos';

    protected $primaryKey = 'cfc_id';

	public $timestamps = false;

    protected $fillable = [
        'cfc_idTercero',
        'cfc_tipocorreo',
        'cfc_aprueba',
        'cfc_estado'
    ];

    protected $guarded = [];

        
}