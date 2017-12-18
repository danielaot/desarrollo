<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TAdministradore
 */
class TAdministradore extends Model
{
    protected $table = 't_administradores';

    protected $primaryKey = 'adp_id';

	public $timestamps = false;

    protected $fillable = [
        'adp_idTercero',
        'adp_tipo',
        'adp_estado'
    ];

    protected $guarded = [];

        
}