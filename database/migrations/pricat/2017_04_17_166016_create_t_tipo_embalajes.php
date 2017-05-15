<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTTipoEmbalajes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_tipo_embalajes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('temb_calificador');
            $table->string('temb_nombre');
            $table->timestamps();
        });
    }
}
