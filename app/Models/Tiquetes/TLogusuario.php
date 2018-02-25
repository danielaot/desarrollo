<?php

namespace App\Models\Tiquetes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TLogusuario
 */
class TLogusuario extends Model
{   
    protected $connection = 'tiqueteshotel';
    
    protected $table = 't_logusuario';

    protected $primaryKey = 'log_id';

	public $timestamps = false;

    protected $fillable = [
        'usu_id',
        'log_num_creacion',
        'log_txt_ip',
        'log_txt_url',
        'log_num_tipo'
    ];

    protected $guarded = [];


}
