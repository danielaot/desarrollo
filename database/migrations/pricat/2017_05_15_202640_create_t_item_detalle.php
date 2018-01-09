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
            $table->string('ide_desinvima');
      			$table->unsignedInteger('ide_catlogyca');
            $table->foreign('ide_catlogyca')->references('id')
                  ->on('t_categorias_logyca')
                  ->onDelete('cascade');
            $table->unsignedInteger('ide_catexito');
            $table->foreign('ide_catexito')->references('id')
                  ->on('t_categorias_exito')
                  ->onDelete('cascade');
      			$table->string('ide_nomfab');
      			$table->string('ide_origen');
      			$table->string('ide_clase');
      			$table->string('ide_tmarca');
      			$table->string('ide_toferta')->default('noap');
      			$table->string('ide_meprom')->nullable();
      			$table->string('ide_tiprom')->default('noap');
      			$table->string('ide_presentacion');
      			$table->string('ide_varbesa');
      			$table->string('ide_comp1')->default('noap');
      			$table->string('ide_comp2')->default('noap');
      			$table->string('ide_comp3')->default('noap');
      			$table->string('ide_comp4')->default('noap');
      			$table->string('ide_comp5')->default('noap');
      			$table->string('ide_comp6')->default('noap');
      			$table->string('ide_comp7')->default('noap');
      			$table->string('ide_comp8')->default('noap');
      			$table->string('ide_categoria');
      			$table->string('ide_linea');
      			$table->string('ide_sublinea');
      			$table->string('ide_sublineamer');
      			$table->string('ide_sublineamer2');
      			$table->string('ide_submarca');
      			$table->string('ide_regalias')->default('noap');
      			$table->string('ide_segmento')->default('noap');
      			$table->string('ide_clasificacion')->default('noap');
      			$table->string('ide_acondicionamiento')->default('noap');
      			$table->string('ide_nomtemporada')->default('noap');
      			$table->string('ide_anotemporada')->default('noap');
            $table->string('ide_estadoref');
      			$table->string('ide_posarancelaria')->nullable();
      			$table->string('ide_grupoimpositivo')->nullable();
            $table->float('ide_alto', 11, 3);
            $table->float('ide_ancho', 11, 3);
            $table->float('ide_profundo', 11, 3);
            $table->float('ide_volumen', 11, 3);
            $table->float('ide_pesobruto', 11, 3);
            $table->float('ide_pesoneto', 11, 3);
            $table->float('ide_tara', 11, 3);
            $table->unsignedInteger('ide_temp')->nullable();
            $table->foreign('ide_temp')->references('id')
                  ->on('t_tipo_empaques')
                  ->onDelete('cascade');
            $table->unsignedInteger('ide_condman')->nullable();
            $table->foreign('ide_condman')->references('id')
                  ->on('t_cond_manipulacion')
                  ->onDelete('cascade');
            $table->unsignedInteger('ide_regsan')->nullable();
            $table->foreign('ide_regsan')->references('id')
                  ->on('t_notificacion_sanitaria')
                  ->onDelete('cascade');
      			$table->timestamps();
        });
    }
}
