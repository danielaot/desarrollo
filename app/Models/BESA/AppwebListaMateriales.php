<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class AppwebListaMateriales extends Model
{
    protected $connection = 'besa';

    protected $table = '9000-appweb_lista_materiales';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'ID_Item',
        'Cod_Item',
        'Nom_Item',
        'estadoitem',
        'Cant_Requerida',
        'Cod_Item_Componente',
        'Nom_Item_Componente',
        'ID_Item_Componente',
        'Tipo_Item_Componente',
        'UM_Item_Componente',
        'CodLinea',
        'NomLinea',
        'CodTipodeInventario',
        'NomTipodeInventario',
        'Tipo_Inventario',
        'Costo',
        'metodo',
        'desc_metodo',
        'CodTipoMaterial_I',
        'NomTipoMaterial_I',
        'vlr_tam_cont',
        'um_tam_cont'
    ];
}
