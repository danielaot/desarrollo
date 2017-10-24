<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ite_proy');
            $table->foreign('ite_proy')->references('id')
                  ->on('t_proyectos');
            $table->string('ite_referencia');
            $table->string('ite_tproducto');
            $table->string('ite_eanext')->nullable();
            $table->string('ite_ean13')->nullable();
            $table->string('ite_estado')->default('1201');
            $table->enum('ite_est_logyca', ['Certificado','Capturado','No Capturado'])->default('No Capturado');
            $table->timestamps();
        });
    }
}
