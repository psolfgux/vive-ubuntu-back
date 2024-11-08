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
    Schema::create('game_cards', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_game')->constrained('player_tematica')->onDelete('cascade');
        $table->foreignId('id_card')->constrained('cartas')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_cards');
    }
};
