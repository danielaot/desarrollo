<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCondManipulacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_cond_manipulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tcman_calificador');
            $table->string('tcman_nombre');
            $table->timestamps();
        });
    }
}
