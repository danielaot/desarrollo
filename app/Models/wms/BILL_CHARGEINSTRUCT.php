<?php

namespace App\Models\wms;

use Illuminate\Database\Eloquent\Model;

class BILL_CHARGEINSTRUCT extends Model
{
    protected $connection = 'intsce';

    protected $table = 'SCPRD.wmwhse1.BILL_CHARGEINSTRUCT';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'CHARGE_CODE',
        'CHARGE_QTY',
        'TRAN_KEY1'
    ];
}
