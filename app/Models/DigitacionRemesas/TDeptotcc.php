<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDeptotcc
 */
class TDeptotcc extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_deptotcc';

    protected $primaryKey = 'dep_id';

	public $timestamps = false;

    protected $fillable = [
        'dep_txt_nomdepto',
        'dep_txt_nomabreviado'
    ];

    protected $guarded = [];


}
