<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Player;

class HomePage extends Controller
{
    public function index()
    {
        // Obtener los jugadores con la cuenta de temáticas y de cartas leídas
        $players = Player::withCount('tematicas')
            ->withCount(['readCards as read_cards_count'])
            ->get();

        // Pasar los datos a la vista
        return view('content.pages.pages-home', compact('players'));
    }
}
