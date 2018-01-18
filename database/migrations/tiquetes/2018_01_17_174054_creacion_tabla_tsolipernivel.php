<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaTsolipernivel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tiqueteshotel')->create('t_solipernivel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sni_idpernivel')->unsigned();
            $table->string('sni_cedula');
            $table->integer('sni_idsolicitud')->unsigned();
            $table->tinyInteger('sni_estado')->length(1)->comment('Estado de aprobacion donde [0] es Pendiente por Aprobar y [1] es Aprobada');
            $table->string('sni_orden');
            $table->timestamps();

            // $table->foreign('sni_idpernivel')->references('id')->on('t_perniveles');
            // $table->foreign('sni_idsolicitud')->references('solIntSolId')->on('t_solicitud');
        });
    }

}
