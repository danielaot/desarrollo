<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoorden
 */
class TTipoorden extends Model
{
    protected $table = 't_tipoorden';

    protected $primaryKey = 'toc_id';

	public $timestamps = false;

    protected $fillable = [
        'toc_descripcion',
        'toc_estado'
    ];

    protected $guarded = [];

        
}