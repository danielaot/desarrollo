<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaTgrupopersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tiqueteshotel')->create('t_grupopersona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gpp_idgrupo');
            $table->integer('gpp_idpernivel')->unsigned();
            $table->timestamps();

            //$table->foreign('gpp_idpernivel')->references('id')->on('t_perniveles');
        });
    }
}
