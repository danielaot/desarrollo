<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCuentasrubro
 */
class TCuentasrubro extends Model
{
    protected $table = 't_cuentasrubro';

    protected $primaryKey = 'cur_id';

	public $timestamps = false;

    protected $fillable = [
        'cur_tib_id',
        'cur_cuenta',
        'cur_estado'
    ];

    protected $guarded = [];

        
}