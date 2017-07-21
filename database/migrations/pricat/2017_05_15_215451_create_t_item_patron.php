<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTItemPatron extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_item_patron', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ipa_item');
            $table->foreign('ipa_item')->references('id')
                  ->on('t_items')
                  ->onDelete('cascade');
            $table->unsignedInteger('ipa_numtendidos');
            $table->unsignedInteger('ipa_cajten');
            $table->unsignedInteger('ipa_tenest');
            $table->unsignedInteger('ipa_undten');
            $table->unsignedInteger('ipa_undest');
            $table->unsignedInteger('ipa_caest');
            $table->timestamps();
        });
    }
}
