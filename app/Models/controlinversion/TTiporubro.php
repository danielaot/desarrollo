<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTiporubro
 */
class TTiporubro extends Model
{
    protected $table = 't_tiporubro';

    protected $primaryKey = 'tib_id';

	public $timestamps = false;

    protected $fillable = [
        'tib_descripcion',
        'tib_estado'
    ];

    protected $guarded = [];

        
}