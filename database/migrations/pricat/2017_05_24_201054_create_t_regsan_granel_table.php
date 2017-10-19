<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTRegsanGranelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_regsan_granel', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rsg_not_san');
            $table->foreign('rsg_not_san')->references('id')
                  ->on('t_notificacion_sanitaria')
                  ->onDelete('cascade');
            $table->string('rsg_ref_granel');
            $table->timestamps();
        });
    }}
