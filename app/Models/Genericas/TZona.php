<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TZona extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_zona';

    protected $primaryKey = 'zon_id';

    public $timestamps = false;

    protected $fillable = [
        'zon_txt_descrip'
    ];
}
