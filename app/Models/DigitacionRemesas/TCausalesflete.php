<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCausalesflete
 */
class TCausalesflete extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_causalesfletes';

    protected $primaryKey = 'cau_id';

	public $timestamps = false;

    protected $fillable = [
        'cau_txt_descripcion'
    ];

    protected $guarded = [];


}
