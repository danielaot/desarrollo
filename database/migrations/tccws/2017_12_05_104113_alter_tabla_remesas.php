<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablaRemesas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('conectortccws')->table('t_remesas', function (Blueprint $table) {
            $table->boolean('rms_remesapadre')->nullable()->after('rms_pesototal')->comment('determina si la remesa es hija de una remesa sin boomerang');
            $table->boolean('rms_isBoomerang')->default(false)->after('rms_remesapadre')->comment('determina si la remesa es boomerang de otra remesa');
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
