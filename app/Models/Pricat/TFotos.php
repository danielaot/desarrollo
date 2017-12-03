<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TFotos extends Model
{

  protected $connection = 'pricat';

  protected $table = 't_fotos';

  protected $fillable = [
    'fot_id_item',
    'fot_foto'
  ];

}
