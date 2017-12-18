<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TFacturaraasiste
 */
class TFacturaraasiste extends Model
{
    protected $table = 't_facturaraasiste';

    protected $primaryKey = 'fas_id';

	public $timestamps = false;

    protected $fillable = [
        'fas_fca_id',
        'fas_idTercero',
        'fas_estado'
    ];

    protected $guarded = [];

        
}