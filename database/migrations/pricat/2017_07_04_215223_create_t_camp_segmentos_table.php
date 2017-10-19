<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCampSegmentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_camp_segmentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cse_nombre');
            $table->string('cse_campo');
            $table->string('cse_segmento');
            $table->unsignedInteger('cse_orden');
            $table->enum('cse_grupo', ['a','b','c','d','z'])->default('b');
            $table->enum('cse_tnovedad', ['codificacion','activacion','suspension','precios','eliminacion'])->default('codificacion');
            $table->timestamps();
        });
    }
}
