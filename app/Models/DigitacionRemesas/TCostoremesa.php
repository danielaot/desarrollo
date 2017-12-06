<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCostoremesa
 */
class TCostoremesa extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_costoremesa';

    protected $primaryKey = 'ctr_id';

	public $timestamps = false;

    protected $fillable = [
        'ctr_txt_monto',
        'ctr_txt_fechacre'
    ];

    protected $guarded = [];


}
