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
            $table->string('rms_observacion')->comment('Se asigna la observacion de la remesa que se envia a tcc');
            $table->string('rms_terceroid')->comment('Codigo de tercero al que se le envia el despacho');
            $table->string('rms_sucu_cod')->comment('Codigo de la sucursal del tercero al que se le envia el despacho');
            $table->string('rms_txt_vehiculo')->comment('Numero o Placa del Vehiculo donde se movilizara el despacho');
            $table->string('rms_ciud_sucursal')->comment('Ciudad de la sucursal');
            $table->string('rms_nom_sucursal')->comment('Se asigna el nombre de la sucursal que a la que se despacha');
            $table->integer('rms_cajas')->unsigned()->comment('Cantidad de cajas del despacho');
            $table->integer('rms_lios')->unsigned()->comment('Cantidad de lios del despacho');
            $table->double('rms_pesolios', 15, 8)->comment('peso total de lios del despacho');
            $table->double('rms_pesoliostcc', 15, 8)->comment('peso total de lios enviados a tcc despues de la division');
            $table->integer('rms_palets')->unsigned()->comment('Cantidad de estibas del despacho');
            $table->double('rms_pesopalets', 15, 8)->comment('peso total de estibas del despacho');
            $table->double('rms_pesopaletstcc', 15, 8)->comment('peso total de estibas del despacho enviados a tcc despues de la division');
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
