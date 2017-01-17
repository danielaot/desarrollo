<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TItemgrado
 */
class TItemGrados extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_itemgrados';

    public $timestamps = false;

    protected $fillable = [
        'ite_id',
        'cen_id',
        'ite_num_operacion',
        'ite_txt_operacion',
        'ite_num_grados'
    ];
}
