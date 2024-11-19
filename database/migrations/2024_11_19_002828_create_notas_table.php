<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Ejecuta la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id(); // Crea un campo `id` auto-incremental
            $table->foreignId('tematica_id')->constrained()->onDelete('cascade'); // Relación con la tabla `tematicas`
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade'); // Relación con la tabla `players`, asumiendo que tienes una tabla `players`
            $table->integer('valor')->unsigned()->default(0); // Valor de la nota (0-10)
            $table->timestamps(); // Timestamps de creación y actualización
        });
    }

    /**
     * Revierte la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
