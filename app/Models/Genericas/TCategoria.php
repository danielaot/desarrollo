<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCategoria extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_categoria';

    protected $primaryKey = 'cat_id';

    public $timestamps = false;

    protected $fillable = [
        'cat_txt_descrip',
    ];

    public function lineas()
  	{
  		  return $this->belongsTo('App\Models\Genericas\TLineas', 'cat_id', 'cat_id');
  	}
}
