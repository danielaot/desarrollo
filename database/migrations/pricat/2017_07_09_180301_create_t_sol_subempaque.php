<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTSolSubempaque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_sol_subempaques', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ssu_proy');
            $table->foreign('ssu_proy')->references('id')
                  ->on('t_proyectos');
            $table->unsignedInteger('ssu_item');
            $table->foreign('ssu_item')->references('id')
                  ->on('t_items')
                  ->onDelete('cascade');
            $table->unsignedInteger('ssu_cantemb');
            $table->string('ssu_user');
            $table->enum('ssu_estado',['solicitado','creado'])->default('solicitado');
            $table->timestamps();
        });
    }
}
