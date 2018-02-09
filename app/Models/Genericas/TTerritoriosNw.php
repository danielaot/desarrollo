<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TTerritoriosNw extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_territorio_nw';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'tnw_descripcion',
        'tnw_zonaid',
        'tnw_estado'
    ];

    public function zona (){
      return $this->hasOne('App\Models\Genericas\TZonaNw', 'id', 'tnw_zonaid');
    }
}
