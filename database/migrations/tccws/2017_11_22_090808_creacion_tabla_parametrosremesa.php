<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaParametrosremesa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('conectortccws')->create('t_parametros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('par_campoTcc');
            $table->string('par_campoVariable');
            $table->string('par_valor');
            $table->enum('par_grupo',['a','b','c','z']);
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
        //
    }
}
