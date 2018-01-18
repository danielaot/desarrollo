<?php

namespace App\Models\wms;

use Illuminate\Database\Eloquent\Model;

class UPL_ORDERS extends Model
{
    protected $connection = 'intsce';

    protected $table = 'INTSCE.interface.UPL_ORDERS';

    public $incrementing = false;

    public $timestamps = false;
    protected $primaryKey = 'uplrid';

    protected $fillable = [
        'SERIALKEY',
        'WHSEID',
        'TRANSMITLOGKEY',
        'TABLENAME',
        'KEY1',
        'KEY2',
        'KEY3',
        'KEY4',
        'KEY5',
        'A01',
        'A02',
        'A03',
        'A04',
        'A05',
        'A06',
        'A07',
        'A08',
        'A09',
        'A10',
        'A11',
        'A12',
        'A13',
        'A14',
        'A15',
        'A16',
        'A17',
        'A18',
        'A19',
        'A20',
        'A21',
        'A22',
        'A23',
        'A24',
        'A25',
        'A26',
        'A27',
        'A28',
        'A29',
        'A30',
        'N01',
        'N02',
        'N03',
        'N04',
        'N05',
        'N06',
        'N07',
        'N08',
        'N09',
        'N10',
        'N11',
        'N12',
        'N13',
        'N14',
        'N15',
        'N16',
        'N17',
        'N18',
        'N19',
        'N20',
        'F01',
        'F02',
        'F03',
        'F04',
        'F05',
        'F06',
        'F07',
        'F08',
        'F09',
        'F10',
        'STATUS_CTRL',
        'MESSAGE'
    ];

    public function empaques(){
    	return $this->hasMany('App\Models\wms\BILL_CHARGEINSTRUCT', 'TRAN_KEY1', 'A22');
    }

    public function infoFactura(){
    	return $this->hasOne('App\Models\BESA\Informacion_Factura', 'f_num_factura', 'A29');
    }
}
