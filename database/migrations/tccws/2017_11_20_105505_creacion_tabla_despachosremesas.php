<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaDespachosremesas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('conectoressiesa')->create('t_docto_despachostcc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ddt_nombre');
            $table->string('ddt_campo');
            $table->string('ddt_segmento');
            $table->integer('ddt_longitud');
            $table->enum('ddt_tipo', ['string', 'integer']);
            $table->integer('ddt_orden');
            $table->enum('ddt_grupo', ['a', 'b', 'c', 'z']);
            $table->timestamps();
            $table->softDeletes();
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
