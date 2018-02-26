<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TGrupo
 */
class TGrupo extends Model
{
    protected $table = 't_grupo';

    protected $connection = 'genericas';

    public $timestamps = false;

    protected $fillable = [
        'gru_sigla',
        'gru_descripcion',
        'gru_estado'
    ];

    protected $guarded = [];

    public function gruppernivel(){
        return $this->hasMany('App\Models\Tiquetes\TPersonaDepende', 'perdepIntGrupo', 'id');
    }
}
