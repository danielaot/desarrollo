<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TItemEan extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_item_ean';

    protected $fillable = [
        'iea_item',
        'iea_ean',
        'iea_cantemb',
        'iea_principal'
    ];

    public function items()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TItem', 'iea_item');
  	}
}
