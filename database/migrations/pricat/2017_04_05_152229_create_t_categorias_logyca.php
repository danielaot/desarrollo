<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCategoriasLogyca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_categorias_logyca', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tcl_codigo');
            $table->string('tcl_descripcion');
            $table->timestamps();
        });
    }
}
