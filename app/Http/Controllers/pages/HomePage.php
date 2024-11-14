<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Tematica;
use App\Models\GameCard; 
use Illuminate\Support\Facades\DB;

class HomePage extends Controller
{
    public function index()
    {
        // Obtener los jugadores con la cuenta de temáticas y de cartas leídas
        $players = Player::withCount('tematicas')
            ->withCount(['readCards as read_cards_count'])
            ->get();

            $totalPlayers = Player::count();
            $totalTematicas = Tematica::count();
            $totalCards = GameCard::count();

            $tematicaCounts = DB::table('player_tematica')
            ->join('tematicas', 'player_tematica.id_tematica', '=', 'tematicas.id')
            ->select('tematicas.titulo', DB::raw('COUNT(player_tematica.id_player) as player_count'))
            ->groupBy('tematicas.id', 'tematicas.titulo')
            ->get();

            return view('content.pages.pages-home', compact('players', 'totalPlayers', 'totalTematicas', 'totalCards', 'tematicaCounts'));
    }
}
