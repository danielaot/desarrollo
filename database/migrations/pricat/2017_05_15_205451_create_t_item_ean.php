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
            $table->unsignedInteger('iea_cantemb');
            $table->string('ide_descorta');
      			$table->string('ide_deslarga');
            $table->float('iea_alto', 11, 3);
            $table->float('iea_ancho', 11, 3);
            $table->float('iea_profundo', 11, 3);
            $table->float('iea_volumen', 11, 3);
            $table->float('iea_pesobruto', 11, 3);
            $table->float('iea_pesoneto', 11, 3);
            $table->float('iea_tara', 11, 3);
            $table->boolean('iea_principal')->default(false);
            $table->timestamps();
        });
    }
}
