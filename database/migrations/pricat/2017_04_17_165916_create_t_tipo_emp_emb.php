<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTTipoEmpEmb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_tipo_emp_emb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tem_calificador');
            $table->string('tem_nombre');
            $table->timestamps();
        });
    }
}
