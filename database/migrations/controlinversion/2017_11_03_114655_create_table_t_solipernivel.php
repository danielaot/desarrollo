<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTSolipernivel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('bd_controlinversion')->create('t_solipernivel', function (Blueprint $table) {

          $table->increments('id');
          $table->integer('sni_usrnivel')->unsigned()->comment('Id del usuario creado en t_perniveles');
          $table->string('sni_cedula')->length(50)->comment('cedula del usuario que debe aprobar la solicitud');
          $table->integer('sni_sci_id')->length(11)->comment('Id de solicitud que se va aprobar');
          $table->tinyInteger('sni_estado')->length(1)->comment('Estado de aprobacion donde [0] es Pendiente por Aprobar y [1] es Aprobada');
          $table->integer('sni_orden')->nullable()->comment('Orden de aprobacion para personas de nivel 3');
          $table->timestamps();

          $table->foreign('sni_usrnivel')->references('id')->on('t_perniveles');
          $table->foreign('sni_sci_id')->references('sci_id')->on('t_solicitudctlinv');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
