<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCoCanal extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_co_canal';

    protected $primaryKey = 'coc_id';

	  public $timestamps = false;

    protected $fillable = [
        'coc_cen_id',
        'coc_can_id'
    ];
}
