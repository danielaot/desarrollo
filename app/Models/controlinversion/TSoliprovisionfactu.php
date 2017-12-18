<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliprovisionfactu
 */
class TSoliprovisionfactu extends Model
{
    protected $table = 't_soliprovisionfactu';

    protected $primaryKey = 'spf_id';

	public $timestamps = false;

    protected $fillable = [
        'spf_pro_id',
        'spf_fechafactura',
        'spf_nfactura',
        'spf_valor',
        'spf_estado'
    ];

    protected $guarded = [];

        
}