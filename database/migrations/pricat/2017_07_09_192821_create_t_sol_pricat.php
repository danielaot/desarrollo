<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTSolPricat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_sol_pricat', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sop_cliente');
            $table->foreign('sop_cliente')->references('id')
                  ->on('t_clientes')
                  ->onDelete('cascade');
            $table->string('sop_kam');
            $table->enum('sop_tnovedad', ['codificacion','activacion','suspension','precios','eliminacion'])->default('codificacion');
            $table->date('sop_fecha_inicio');
            $table->date('sop_fecha_fin')->nullable();
            $table->enum('sop_estado', ['solicitado','creado'])->default('solicitado');
            $table->timestamps();
        });
    }
}
