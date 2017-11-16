<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TRechazos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('pricat')->create('t_rechazos', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('rec_id_proy');
          $table->foreign('rec_id_proy')->references('dac_proy_id')->on('t_desarrollo_actividades');
          $table->unsignedInteger('rec_id_act');
          $table->foreign('rec_id_act')->references('id')->on('t_actividades');
          $table->string('rec_observacion');
          $table->timestamps();
        });
    }
}
