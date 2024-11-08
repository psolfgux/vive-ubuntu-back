<?php
namespace App\Http\Controllers;

use App\Models\PlayerTematica;
use Illuminate\Http\Request;

class PlayerTematicaController extends Controller
{
    // Obtener todos los registros
    public function index()
    {
        return PlayerTematica::with(['player', 'tematica'])->get();
    }

    public function store(Request $request)
{
    // Validación de los datos entrantes
    $validatedData = $request->validate([
        'id_player' => 'required|exists:players,id',
        'id_tematica' => 'required|exists:tematicas,id',
    ]);

    // Verificar si la combinación de id_player y id_tematica ya existe
    $existingRecord = PlayerTematica::where('id_player', $validatedData['id_player'])
                                    ->where('id_tematica', $validatedData['id_tematica'])
                                    ->first();

    if ($existingRecord) {
        // Si ya existe, devolver un mensaje de error
        //return response()->json([
            //'message' => 'La combinación de jugador y temática ya ha sido registrada.',
        //], 409); // Código de estado HTTP 409 (Conflicto)
        return response()->json($existingRecord, 201);
    }

    // Si no existe, crear el nuevo registro
    $playerTematica = PlayerTematica::create($validatedData);

    return response()->json($playerTematica, 201); // Respuesta exitosa
}


    // Mostrar un registro específico
    public function show($id)
    {
        $playerTematica = PlayerTematica::with(['player', 'tematica'])->findOrFail($id);
        return response()->json($playerTematica);
    }

    // Actualizar un registro
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_player' => 'required|exists:players,id',
            'id_tematica' => 'required|exists:tematicas,id',
        ]);

        $playerTematica = PlayerTematica::findOrFail($id);
        $playerTematica->update($validatedData);

        return response()->json($playerTematica);
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $playerTematica = PlayerTematica::findOrFail($id);
        $playerTematica->delete();

        return response()->json(null, 204);
    }
}
