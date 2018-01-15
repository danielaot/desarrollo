<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaFacturasRemesas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('conectortccws')->create('t_factsxremesa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fxr_remesa')->unsigned()->comment('relacion foranea con tabla t_remesas');
            $table->string('fxr_ordencompra')->comment('Se almacena la orden de compra de la factura');          
            $table->string('fxr_tipodocto')->comment('tipo de documento de factura enviada a tcc');
            $table->string('fxr_numerodocto')->comment('numero de documento o factura');
            $table->string('fxr_fechadocto')->comment('fecha de creacion de la factura');
            $table->string('fxr_valorfactura')->comment('Se almacena el valor total de la factura');
            $table->string('fxr_unidadesfactura')->comment('Unidades facturadas de factura');
            $table->string('fxr_itemsfactura')->comment('Cantidad de items en factura');
            $table->timestamps();

            $table->foreign('fxr_remesa')->references('id')->on('t_remesas');
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
