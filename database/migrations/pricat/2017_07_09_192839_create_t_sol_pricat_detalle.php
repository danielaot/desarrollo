<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTSolPricatDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_sol_pricat_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('spd_sol');
            $table->foreign('spd_sol')->references('id')
                  ->on('t_sol_pricat')
                  ->onDelete('cascade');
            $table->string('spd_referencia');
            $table->unsignedInteger('spd_preciobruto')->nullable();
            $table->unsignedInteger('spd_preciosugerido')->nullable();
            $table->timestamps();
        });
    }
}
