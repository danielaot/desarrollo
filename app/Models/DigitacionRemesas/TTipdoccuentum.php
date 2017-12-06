<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipdoccuentum
 */
class TTipdoccuentum extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_tipdoccuenta';

    protected $primaryKey = 'tip_id';

	public $timestamps = false;

    protected $fillable = [
        'tip_num_cuentaremite',
        'tip_txt_tipodocumento'
    ];

    protected $guarded = [];


}
