<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TCliente extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_cliente';

    protected $primaryKey = 'cli_id';

    public $timestamps = false;

    protected $fillable = [
        'ter_id',
        'razonSocialTercero_cli',
        'can_id',
        'lis_id',
        'cli_txt_dtocome',
        'cli_num_resiva',
        'cli_num_decrenta',
        'cli_num_grancont',
        'cli_num_autiva',
        'cli_num_autica',
        'cli_num_autrenta',
        'cli_subcanal',
    ];

    public function sucursalestcc(){
      return $this->hasMany('App\Models\Genericas\TSucursal','cli_id','cli_id');
    }

    public function tercerotcc(){
        return $this->hasOne('App\Models\Genericas\Tercero','idTercero', 'ter_id');
    }
}
