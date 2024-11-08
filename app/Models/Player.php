<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Player extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Encripta la contraseña antes de guardarla.
     */
    //public function setPasswordAttribute($password)
    //{
        //if ($password) {
            //$this->attributes['password'] = bcrypt($password);
        //}
    //}

    /**
     * Métodos requeridos por JWTSubject
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Generalmente es el id del usuario
    }

    public function getJWTCustomClaims()
    {
        return [];  // Aquí puedes añadir cualquier información adicional al token si lo deseas
    }

    public function tematicas()
    {
        return $this->hasMany(PlayerTematica::class, 'id_player');
    }

    // Relación para obtener las cartas leídas a través de temáticas
    public function readCards()
    {
        return $this->hasManyThrough(GameCard::class, PlayerTematica::class, 'id_player', 'id_game', 'id', 'id_tematica');
    }
}
