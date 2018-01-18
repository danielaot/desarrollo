<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaTperniveles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tiqueteshotel')->create('t_perniveles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pen_usuario');
            $table->string('pen_nombre');
            $table->string('pen_cedula');
            $table->string('pen_idtipoper');
            $table->integer('pen_jefe');
            $table->integer('pen_nomnivel')->unsigned();
            $table->timestamps();

            //$table->foreign('pen_nomnivel')->references('id')->on('t_niveles');
        });
    }

}
