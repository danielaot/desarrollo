<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaTCiudadestcc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('conectortccws')->create('t_ciudadestcc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ctc_tipo_geo')->nullable();
            $table->string('ctc_cod_sion')->nullable();
            $table->string('ctc_dept_id')->nullable();
            $table->string('ctc_depa_desc')->nullable();
            $table->string('ctc_cod_dane')->nullable();
            $table->string('ctc_ciu_tcc')->nullable();
            $table->string('ctc_dept_erp')->nullable();
            $table->string('ctc_ciu_erp')->nullable();
            $table->string('ctc_ciu_abrv')->nullable();
            $table->string('ctc_pais_id')->nullable();
            $table->string('ctc_pais_abrv')->nullable();
            $table->string('ctc_ticg_id_int')->nullable();
            $table->string('ctc_ticg_desc')->nullable();
            $table->string('ctc_loca_id_int')->nullable();
            $table->string('ctc_cop')->nullable();
            $table->string('ctc_reex')->nullable();
            $table->string('ctc_estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
