<?php

namespace App\Models\tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TGrupopersona
 */
class TGrupopersona extends Model
{
	protected $connection = 'tiqueteshotel';
	
    protected $table = 't_grupopersona';

    public $timestamps = true;

    protected $fillable = [
        'gpp_idgrupo',
        'gpp_idpernivel'
    ];

    protected $guarded = [];

        
}