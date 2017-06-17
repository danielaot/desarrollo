<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTItemDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pricat')->create('t_item_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ide_item');
            $table->foreign('ide_item')->references('id')
                  ->on('t_items')
                  ->onDelete('cascade');
            $table->string('ide_uso');
      			$table->string('ide_marca');
      			$table->string('ide_variedad');
      			$table->string('ide_contenido');
      			$table->string('ide_umcont');
      			$table->string('ide_descorta');
      			$table->string('ide_deslarga');
      			$table->string('ide_descompleta');
      			$table->string('ide_catlogyca');
      			$table->string('ide_nomfab');
      			$table->string('ide_origen');
      			$table->string('ide_tmarca');
      			$table->string('ide_toferta')->nullable();
      			$table->string('ide_meprom')->nullable();
      			$table->string('ide_tiprom')->nullable();
      			$table->string('ide_presentacion');
      			$table->string('ide_varbesa');
      			$table->string('ide_comp1')->nullable();
      			$table->string('ide_comp2')->nullable();
      			$table->string('ide_comp3')->nullable();
      			$table->string('ide_comp4')->nullable();
      			$table->string('ide_categoria');
      			$table->string('ide_linea');
      			$table->string('ide_sublinea');
      			$table->string('ide_sublineamer');
      			$table->string('ide_sublineamer2');
      			$table->string('ide_submarca')->default('noap');
      			$table->string('ide_regalias')->default('noap');
      			$table->string('ide_segmento')->default('noap');
      			$table->string('ide_clasificacion')->default('noap');
      			$table->string('ide_acondicionamiento')->default('noap');
      			$table->string('ide_nomtemporada')->nullable();
      			$table->string('ide_anotemporada')->nullable();
      			$table->string('ide_posarancelaria')->nullable();
      			$table->string('ide_grupoimpositivo')->nullable();
      			$table->timestamps();
        });
    }
}
