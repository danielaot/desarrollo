<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCanal extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_canal';

    protected $primaryKey = 'can_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'can_txt_descrip',
    ];

    public function canalesperniveles(){
        return $this->hasMany('App\Models\Tiquetes\TPersonaDepende', 'perdepIntCanal', 'can_id');
    }
}
