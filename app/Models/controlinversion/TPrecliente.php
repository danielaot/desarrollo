<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPrecliente
 */
class TPrecliente extends Model
{
    protected $table = 't_precliente';

    protected $primaryKey = 'prc_id';

	public $timestamps = false;

    protected $fillable = [
        'prc_cli_id',
        'prc_prefijo',
        'prc_estado'
    ];

    protected $guarded = [];

        
}