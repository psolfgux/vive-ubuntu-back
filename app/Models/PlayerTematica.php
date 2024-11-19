<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTematica extends Model
{
    protected $table = 'player_tematica';

    protected $fillable = ['id_player', 'id_tematica'];

    // Relación con el modelo Player
    public function player()
    {
        return $this->belongsTo(Player::class, 'id_player');
    }

    // Relación con el modelo Tematica
    public function tematica()
    {
        return $this->belongsTo(Tematica::class, 'id_tematica');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

}
