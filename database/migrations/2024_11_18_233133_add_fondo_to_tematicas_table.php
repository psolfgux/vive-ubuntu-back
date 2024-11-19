<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tematicas', function (Blueprint $table) {
            $table->string('fondo')->nullable(); // El tipo puede ser string o texto según el tipo de fondo que desees almacenar (ej., URL de imagen, color, etc.)
        });
    }

    public function down()
    {
        Schema::table('tematicas', function (Blueprint $table) {
            $table->dropColumn('fondo');
        });
    }
};
