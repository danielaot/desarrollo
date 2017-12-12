<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRelciudadestcc
 */
class TRelciudadestcc extends Model
{
    protected $connection = 'digitacionremesas';

    protected $table = 't_relciudadestcc';

    protected $primaryKey = 'rel_id';

	public $timestamps = false;

    protected $fillable = [
        'ciu_id',
        'rel_txt_ciudad',
        'rel_txt_departamento'
    ];

    protected $guarded = [];

    public function ciudadtcc(){
      return $this->hasOne('App\Models\DigitacionRemesas\TCiudadtcc', 'ciu_id', 'ciu_id');
    }


}
