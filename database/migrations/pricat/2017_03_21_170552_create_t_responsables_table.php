<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_responsables', function (Blueprint $table) {
            $table->string('res_usuario', 20);
            $table->integer('res_ar_id')->unsigned();
            $table->foreign('res_ar_id')->references('id')
                  ->on('t_areas')
                  ->onDelete('cascade');
            $table->primary(['res_usuario', 'res_ar_id']);
            $table->timestamps();
        });
    }
}
