<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaTniveles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tiqueteshotel')->create('t_niveles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('niv_descripcion');
            $table->timestamps();
        });
    }

}
