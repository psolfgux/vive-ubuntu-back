<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCard extends Model
{
    use HasFactory;

    // Definimos las columnas que pueden ser asignadas masivamente
    protected $fillable = [
        'id_game',
        'id_card',
    ];

    // Relación con el modelo Game
    public function game()
    {
        return $this->belongsTo(Game::class, 'id_game');
    }

    // Relación con el modelo Card
    public function card()
    {
        return $this->belongsTo(Card::class, 'id_card');
    }
}
