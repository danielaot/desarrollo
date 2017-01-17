<?php

namespace App\Models\Aplicativos;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'aplicativos';

    protected $table = 'menu';

    protected $primaryKey = 'idMenu';

    public $timestamps = false;

    protected $fillable = [
        'idPadre',
        'nombreMenu',
        'phpMenu',
        'accesoPublico',
        'txt_icono',
    ];

    public function nivelmenu()
    {
        return $this->hasMany('App\Models\Aplicativos\NivelMenuUsuario','idMenu','idMenu');
    }
}
