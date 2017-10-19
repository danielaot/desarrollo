<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TSolSubempaque extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_sol_subempaques';

    protected $fillable = [
        'ssu_item',
        'ssu_cantemb',
        'ssu_user',
        'ssu_estado'
    ];

    public function items()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TItem', 'ssu_item');
  	}
}
