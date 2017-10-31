<?php

namespace App\Models\wms;

use Illuminate\Database\Eloquent\Model;

class UPL_ORDERS extends Model
{
    protected $connection = 'intsce';

    protected $table = 'INTSCE.interface.UPL_ORDERS';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'A01',
        'A09',
        'A08',
        'A22',
        'A29'
    ];

    public function empaques(){
    	return $this->hasMany('App\Models\wms\BILL_CHARGEINSTRUCT', 'TRAN_KEY1', 'A22');
    }

    public function infoFactura(){
    	return $this->hasOne('App\Models\BESA\Informacion_Factura', 'f_num_factura', 'A29');
    }
}
