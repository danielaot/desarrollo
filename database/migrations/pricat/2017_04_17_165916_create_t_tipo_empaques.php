<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTTipoEmpaques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_tipo_empaques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('temp_calificador');
            $table->string('temp_nombre');
            $table->timestamps();
        });
    }
}
