<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaRemesastcc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('conectortccws')->create('t_remesas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rms_remesa',100)->comment('Se asigna la remesa que retorna tcc en su servicio');
            $table->integer('rms_cajas')->unsigned()->comment('Cantidad de cajas del despacho');
            $table->integer('rms_lios')->unsigned()->comment('Cantidad de lios del despacho');
            $table->double('rms_pesolios', 15, 8)->comment('peso total de lios del despacho');
            $table->integer('rms_palets')->unsigned()->comment('Cantidad de estibas del despacho');
            $table->double('rms_pesopalets', 15, 8)->comment('peso total de estibas del despacho');
            $table->double('rms_pesototal', 15, 8)->comment('peso total del despacho se suman los pesos de estibas y lios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
