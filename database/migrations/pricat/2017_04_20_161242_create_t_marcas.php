<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTMarcas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_marcas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mar_nombre');
            $table->string('mar_linea');
            $table->timestamps();
        });
    }
}
