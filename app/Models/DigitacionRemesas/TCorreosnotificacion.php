<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCorreosnotificacion
 */
class TCorreosnotificacion extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_correosnotificacion';

    protected $primaryKey = 'cno_id';

	public $timestamps = false;

    protected $fillable = [
        'cno_txt_nombre',
        'cno_txt_correo'
    ];

    protected $guarded = [];


}
