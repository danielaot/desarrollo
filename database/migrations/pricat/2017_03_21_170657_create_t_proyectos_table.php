<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_proyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proy_nombre');
            $table->enum('proy_estado', ['En Proceso','Terminado','Pausado','Cancelado'])->default('En Proceso');
            $table->unsignedInteger('proy_proc_id');
            $table->foreign('proy_proc_id')->references('id')
                  ->on('t_procesos')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
}
