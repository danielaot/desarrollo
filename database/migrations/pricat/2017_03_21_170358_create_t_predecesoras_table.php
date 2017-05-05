<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPredecesorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_predecesoras', function (Blueprint $table) {
            $table->integer('pre_act_id')->unsigned();
            $table->foreign('pre_act_id')->references('id')
                  ->on('t_actividades')
                  ->onDelete('cascade');
            $table->integer('pre_act_pre_id')->unsigned();
            $table->foreign('pre_act_pre_id')->references('id')
                  ->on('t_actividades')
                  ->onDelete('cascade');
            $table->primary(['pre_act_id', 'pre_act_pre_id']);
            $table->timestamps();
        });
    }
}
