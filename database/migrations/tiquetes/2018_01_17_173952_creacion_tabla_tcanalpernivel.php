<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaTcanalpernivel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tiqueteshotel')->create('t_canalpernivel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cap_idcanal');
            $table->integer('cap_idpernivel')->unsigned();
            $table->timestamps();

            //$table->foreign('cap_idpernivel')->references('id')->on('t_perniveles');
        });
    }

}
