<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_notificaciones', function (Blueprint $table) {
            $table->string('not_usuario', 20);
            $table->unsignedInteger('not_act_id');
            $table->foreign('not_act_id')->references('id')
                  ->on('t_actividades')
                  ->onDelete('cascade');
            $table->primary(['not_usuario', 'not_act_id']);
            $table->timestamps();
        });
    }
}
