<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    use HasFactory;

    protected $fillable = ['tematica_id', 'titulo', 'descripcion'];

    public function tematica()
    {
        return $this->belongsTo(Tematica::class);
    }
}
