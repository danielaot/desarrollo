<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNovedadbellezaexpress
 */
class TNovedadbellezaexpress extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_novedadbellezaexpress';

    protected $primaryKey = 'nov_id';

	public $timestamps = false;

    protected $fillable = [
        'nov_num_responsable',
        'nov_txt_descripcion'
    ];

    protected $guarded = [];


}
