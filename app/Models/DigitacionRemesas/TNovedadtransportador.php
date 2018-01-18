<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNovedadtransportador
 */
class TNovedadtransportador extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_novedadtransportador';

    protected $primaryKey = 'nov_id';

	public $timestamps = false;

    protected $fillable = [
        'tra_id',
        'nov_num_codigo',
        'nov_txt_descripcion'
    ];

    protected $guarded = [];


}
