<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class AppwebPosarancelaria extends Model
{
    protected $connection = 'besa';

    protected $table = '9000-appweb_posarancelaria';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_pos_arancelaria',
        'desc_pos_arancelaria',
        'desc_adic__pos_arancelaria'
    ];
}
