<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cli_nit');
            $table->boolean('cli_codificacion')->default(false);
            $table->boolean('cli_modificacion')->default(false);
            $table->boolean('cli_eliminacion')->default(false);
            $table->string('cli_kam');
            $table->string('cli_gln');
            $table->timestamps();
        });
    }
}
