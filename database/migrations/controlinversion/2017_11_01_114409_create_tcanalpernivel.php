<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTcanalpernivel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bd_controlinversion')->create('t_canalpernivel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cap_idcanal');
            $table->integer('cap_idlinea');
            $table->integer('cap_idpernivel')->unsigned();
            $table->timestamps();
        });
        Schema::connection('bd_controlinversion')->table('t_canalpernivel', function (Blueprint $table) {
            $table->foreign('cap_idpernivel')->references('id')->on('t_perniveles');
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
