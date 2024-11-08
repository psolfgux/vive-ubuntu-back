<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerTematicaTable extends Migration
{
    public function up()
    {
        Schema::create('player_tematica', function (Blueprint $table) {
            $table->id(); // ID principal
            $table->foreignId('id_player')->constrained('players')->onDelete('cascade');
            $table->foreignId('id_tematica')->constrained('tematicas')->onDelete('cascade');
            $table->timestamps(); // Opcional: para control de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('player_tematica');
    }
}
