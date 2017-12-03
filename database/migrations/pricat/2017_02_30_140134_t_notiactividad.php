<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TNotiactividad extends Migration
{
    public function up()
    {
        Schema::connection('pricat')->create('t_notiactividad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('not_usuario', 20);
            $table->unsignedInteger('not_actividad');
            $table->foreign('not_actividad')->references('id')
                  ->on('t_actividades');
            $table->timestamps();
        });
    }
}
