<?php
namespace App\Http\Controllers;

use App\Models\GameCard;
use Illuminate\Http\Request;

class GameCardController extends Controller
{
    // Listar todas las cartas de un juego
    public function index($id_game)
    {
        $gameCards = GameCard::where('id_game', $id_game)->get();
        return response()->json($gameCards);
    }

    // Crear un nuevo registro GameCard
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_game' => 'required|exists:player_tematica,id',
            'id_card' => 'required|exists:cartas,id',
        ]);

        // Verificar si ya existe el registro
        $existingGameCard = GameCard::where('id_game', $validatedData['id_game'])
            ->where('id_card', $validatedData['id_card'])
            ->first();

        if ($existingGameCard) {
            //return response()->json(['message' => 'Este registro ya existe.'], 409);
            return response()->json(['estado' => 'ok'], 201);
        }

        $gameCard = GameCard::create($validatedData);
        return response()->json($gameCard, 201);
    }

    // Eliminar un registro GameCard
    public function destroy($id)
    {
        $gameCard = GameCard::find($id);

        if (!$gameCard) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $gameCard->delete();
        return response()->json(['message' => 'Registro eliminado'], 200);
    }
}
