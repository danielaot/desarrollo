<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTNotificacionSanitaria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_notificacion_sanitaria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nosa_nombre');
            $table->string('nosa_notificacion');
            $table->date('nosa_fecha_inicio');
            $table->date('nosa_fecha_vencimiento');
            $table->string('nosa_documento');
            $table->timestamps();
        });
    }
}
