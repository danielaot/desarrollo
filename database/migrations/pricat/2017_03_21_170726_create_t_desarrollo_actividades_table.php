<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDesarrolloActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_desarrollo_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dac_proy_id')->unsigned();
            $table->foreign('dac_proy_id')->references('id')
                  ->on('t_proyectos')
                  ->onDelete('cascade');
            $table->integer('dac_act_id')->unsigned();
            $table->foreign('dac_act_id')->references('id')
                  ->on('t_actividades')
                  ->onDelete('cascade');
            $table->date('dac_fecha_inicio')->nullable();
            $table->date('dac_fecha_final')->nullable();
            $table->date('dac_fecha_cumplimiento')->nullable();
            $table->string('dac_usuario', 20)->nullable();
            $table->text('dac_observacion')->nullable();
            $table->enum('dac_estado', ['En Proceso','Pendiente','Completado'])->default('Pendiente');
            $table->timestamps();
        });
    }
}
