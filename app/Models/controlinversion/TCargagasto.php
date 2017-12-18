<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoorden
 */
class TCargagasto extends Model
{
	protected $connection = 'bd_controlinversion';
    protected $table = 't_cargagasto';
    protected $primaryKey = 'cga_id';
	public $timestamps = false;
    protected $fillable = [
        'cga_descripcion',
        'cga_estado'
    ];

    protected $guarded = [];

        
}