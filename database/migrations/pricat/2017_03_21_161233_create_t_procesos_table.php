<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_procesos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pro_nombre');
            $table->text('pro_descripcion');
            $table->timestamps();
        });
    }
}
