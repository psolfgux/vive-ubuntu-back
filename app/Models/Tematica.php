<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'orden', 'color', 'image', 'user_id', 'fondo'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartas()
    {
        return $this->hasMany(Carta::class, 'tematica_id');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

}
