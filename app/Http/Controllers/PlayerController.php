<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    // Mostrar todos los jugadores
    public function index()
    {
        $players = Player::all();
        return view('players.index', compact('players'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('players.create');
    }

    // Guardar nuevo jugador
    public function store(Request $request)
    {
        // Validación de los campos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:players,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Hash de la contraseña
        $validated['password'] = Hash::make($validated['password']);

        // Crear nuevo jugador
        Player::create($validated);

        // Redirigir con un mensaje de éxito
        return redirect()->route('players.index')->with('success', 'Jugador guardado correctamente');
    }

    // Mostrar formulario de edición
    public function edit(Player $player)
    {
        return view('players.edit', compact('player'));
    }

    // Actualizar jugador
    public function update(Request $request, Player $player)
    {
        // Validación de los campos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:players,email,' . $player->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Actualizar la contraseña solo si se proporciona una nueva
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Actualizar el jugador
        $player->update($validated);

        // Redirigir con un mensaje de éxito
        return redirect()->route('players.index')->with('success', 'Jugador actualizado con éxito');
    }

    // Eliminar jugador
    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->route('players.index')->with('success', 'Jugador eliminado con éxito');
    }

    // Retornar todos los jugadores en JSON
    public function all()
    {
        $players = Player::all();
        return response()->json($players);
    }

    // Retornar un jugador específico por ID en JSON
    public function show($id)
    {
        $player = Player::findOrFail($id);
        return response()->json($player);
    }
}
