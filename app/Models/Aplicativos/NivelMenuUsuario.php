<?php

namespace App\Models\Aplicativos;

use Illuminate\Database\Eloquent\Model;

class NivelMenuUsuario extends Model
{
    protected $connection = 'aplicativos';

    protected $table = 'nivelmenuusuario';

    public $timestamps = false;

    protected $fillable = [
        'idMenu',
        'idUsuario',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Aplicativos\User','idUsuario','login');
    }

    public function menu()
    {
        return $this->belongsTo('App\Models\Aplicativos\Menu','idMenu','idMenu');
    }
}
