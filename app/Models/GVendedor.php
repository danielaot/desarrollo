<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GVendedor extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_vendedor';

    protected $primaryKey = 'ter_id';

    public $timestamps = false;

    protected $fillable = [
        'ven_id',
    ];
}
