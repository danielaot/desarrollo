<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTClienteSegmentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_cliente_segmentos', function (Blueprint $table) {
            $table->unsignedInteger('cls_cliente');
            $table->foreign('cls_cliente')->references('id')
                  ->on('t_clientes')
                  ->onDelete('cascade');
            $table->unsignedInteger('cls_segmento');
            $table->foreign('cls_segmento')->references('id')
                  ->on('t_camp_segmentos')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
}
