<?php

namespace App\Models\SCPRD;

use Illuminate\Database\Eloquent\Model;

class VInformacionEmpaqueFactura extends Model
{
    protected $connection = 'intsce';

    protected $table = 'SCPRD.wmwhse1.v_InformacionEmpaqueFactura';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'fecha_remesa',
        'num_factura',
        'tipo_docto',
        'num_consecutivo',
        'num_rowid',
        'nom_tercero',
        'num_sucursal',
        'desc_sucursal',
        'txt_direccion',
        'txt_telefono',
        'num_codigoPais',
        'num_despartamento',
        'num_ciudad',
        'desc_ciudad',
        'desc_departamento',
        'notas',
        'date_creacion',
        'nit_tercero',
        'tipo_empaque',
        'num_empaque'
    ];
}
