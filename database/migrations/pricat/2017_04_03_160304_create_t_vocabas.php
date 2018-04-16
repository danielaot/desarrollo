<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTVocabas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_vocabas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tvoc_palabra');
            $table->string('tvoc_abreviatura');
            $table->timestamps();
        });
    }
}
