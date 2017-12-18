<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TConceptosgenerico
 */
class TConceptosgenerico extends Model
{
    protected $table = 't_conceptosgenericos';

    protected $primaryKey = 'cgr_id';

	public $timestamps = false;

    protected $fillable = [
        'cgr_descripcion',
        'cgr_estado'
    ];

    protected $guarded = [];

        
}