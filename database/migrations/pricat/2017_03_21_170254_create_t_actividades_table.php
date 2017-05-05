<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('act_titulo');
            $table->text('act_descripcion');
            $table->integer('act_proc_id')->unsigned();
            $table->foreign('act_proc_id')->references('id')
                  ->on('t_procesos')
                  ->onDelete('cascade');
            $table->integer('act_ar_id')->unsigned();
            $table->foreign('act_ar_id')->references('id')
                  ->on('t_areas')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
}
