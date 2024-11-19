<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'tematica_id', 
        'player_id', 
        'valor',
    ];

    // Relación con la Temática
    public function tematica()
    {
        return $this->belongsTo(Tematica::class);
    }

    // Relación con el Player (asegurate de tener la relación correcta)
    public function player()
    {
        return $this->belongsTo(Player::class); // Ajusta si el modelo es diferente
    }
}
