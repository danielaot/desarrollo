<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPai
 */
class TPai extends Model
{
    protected $table = 't_pais';

    protected $primaryKey = 'paiIntId';

	public $timestamps = false;

    protected $fillable = [
        'paiTxtNombre',
        'paiTxtEstado'
    ];

    protected $guarded = [];


}
