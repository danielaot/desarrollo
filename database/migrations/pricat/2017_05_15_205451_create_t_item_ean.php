<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTItemEan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_item_ean', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('iea_item');
            $table->foreign('iea_item')->references('id')
                  ->on('t_items')
                  ->onDelete('cascade');
            $table->string('iea_ean')->nullable();
            $table->string('iea_cantemb');
            $table->boolean('iea_principal')->default(false);
            $table->timestamps();
        });
    }
}
