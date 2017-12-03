<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TFotos extends Migration
{

    public function up()
    {
        Schema::connection('pricat')->create('t_fotos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fot_id_item');
            $table->foreign('fot_id_item')->references('id')->on('t_items');
            $table->string('fot_foto');
            $table->timestamps();
        });
    }
}
