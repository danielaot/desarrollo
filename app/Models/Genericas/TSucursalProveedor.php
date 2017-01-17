<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TSucursalProveedor extends Model
{
    protected $table = 't_sucursalproveedor';

    protected $primaryKey = 'suc_id';

	public $timestamps = false;

    protected $fillable = [
        'ter_id',
        'suc_txt_numero',
        'suc_txt_descripcion',
        'suc_txt_estado'
    ];
}
