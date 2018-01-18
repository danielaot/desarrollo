<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPago
 */
class TTipoPago extends Model
{
    protected $table = 't_tip_pago';

    protected $primaryKey = 'id';

	public $timestamps = false;

    protected $fillable = [
        'tipTxtTipo',
        'tipTxtNomTipo',
    ];

    protected $guarded = [];

}
