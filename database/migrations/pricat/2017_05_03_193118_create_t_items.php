<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ite_referencia');
            $table->string('ite_tproducto');
            $table->string('ite_eanext');
            $table->string('ite_uso');
            $table->string('ite_marca');
            $table->string('ite_variedad');
            $table->string('ite_contenido');
            $table->string('ite_umcont');
            $table->string('ite_catlogyca');
            $table->string('ite_cantemb');
            $table->string('ite_nomfab');
            $table->integer('ite_origen')->unsigned();
            $table->integer('ite_tmarca')->unsigned();
            $table->integer('ite_toferta')->unsigned()->nullable();
            $table->integer('ite_mpromo')->unsigned()->nullable();
            $table->integer('ite_tpromo')->unsigned()->nullable();
            $table->integer('ite_presentacion')->unsigned();
            $table->integer('ite_varbesa')->unsigned();
            $table->integer('ite_comp1')->unsigned()->nullable();
            $table->integer('ite_comp2')->unsigned()->nullable();
            $table->integer('ite_comp3')->unsigned()->nullable();
            $table->integer('ite_comp4')->unsigned()->nullable();
            $table->integer('ite_categoria')->unsigned();
            $table->integer('ite_linea')->unsigned();
            $table->integer('ite_sublinea')->unsigned();
            $table->integer('ite_sublineamer')->unsigned();
            $table->integer('ite_sublineamer2')->unsigned();
            $table->integer('ite_submarca')->unsigned();
            $table->integer('ite_regalias')->unsigned();
            $table->integer('ite_segmento')->unsigned()->nullable();
            $table->integer('ite_clasificacion')->unsigned()->nullable();
            $table->integer('ite_acondicionamiento')->unsigned()->nullable();
            $table->timestamps();
        });
    }
}
