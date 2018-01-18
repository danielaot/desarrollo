<?php

namespace App\Models\tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCanalpernivel
 */
class TCanalpernivel extends Model
{
    protected $table = 't_canalpernivel';

    public $timestamps = true;

    protected $fillable = [
        'cap_idcanal',
        'cap_idpernivel'
    ];

    protected $guarded = [];

        
}