<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ar_nombre');
            $table->text('ar_descripcion');
            $table->timestamps();
        });
    }
}
