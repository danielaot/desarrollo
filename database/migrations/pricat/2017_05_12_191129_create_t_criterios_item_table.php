<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCriteriosItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_criterios_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cri_plan');
            $table->string('cri_col_unoe');
            $table->string('cri_col_item');
            $table->boolean('cri_regular')->default(false);
            $table->boolean('cri_estuche')->default(false);
            $table->boolean('cri_oferta')->default(false);
            $table->timestamps();
        });
    }
}
