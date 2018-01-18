<?php

namespace App\Models\SCPRD;

use Illuminate\Database\Eloquent\Model;

class VInformacionEmpaqueFacturaDoctos extends Model
{
    protected $connection = 'intsce';

    protected $table = 'SCPRD.wmwhse1.v_InformacionEmpaqueFactura_doctos';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'tipo_pedido',
        'num_pedidoOV',
        'num_pedido',
        'num_ola',
        'num_ordenCompra',
        'num_ordenWms',
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
    ];
}
