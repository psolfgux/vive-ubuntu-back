<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Tematica;
use App\Models\Player;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    // Mostrar todas las notas de una temática
    public function index()
{
    // Obtener todas las notas
    $notas = Nota::all(); // Esto traerá todas las notas de la base de datos
    
    // Si quieres ordenar por fecha de creación o alguna otra propiedad, puedes hacerlo así:
    // $notas = Nota::orderBy('created_at', 'desc')->get();
    
    return view('notas.index', compact('notas'));
}

    // Crear una nueva nota
    public function store(Request $request)
    {
        // Validar la entrada
        $validated = $request->validate([
            'tematica_id' => 'required|exists:tematicas,id',
            'player_id' => 'required|exists:players,id', // Asegúrate de que 'players' exista
            'valor' => 'required|integer|between:0,10', // Validar que el valor esté entre 0 y 10
        ]);

        // Crear la nota
        Nota::create($validated);

        return redirect()->route('tematicas.index')->with('success', 'Nota guardada correctamente');
    }

    // Eliminar una nota
    public function destroy($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->delete();

        return redirect()->back()->with('success', 'Nota eliminada correctamente');
    }

    public function export()
    {
        // Obtener todas las notas con las relaciones necesarias
        $notas = Nota::with('tematica', 'player')->get();

        // Crear el contenido del CSV
        $csvContent = "ID,Temática,Jugador,Email,Valor,Creado\n";

        foreach ($notas as $nota) {
            $csvContent .= "{$nota->id},";
            $csvContent .= "{$nota->tematica->titulo},";
            $csvContent .= "{$nota->player->name},";
            $csvContent .= "{$nota->player->email},";
            $csvContent .= "{$nota->valor},";
            $csvContent .= "{$nota->created_at->format('d/m/Y H:i')}\n";
        }

        // Crear una respuesta con el archivo CSV
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="notas.csv"');
    } 

    public function save(Request $request)
    {
        // Guardar la calificación directamente sin validación
        $nota = new Nota();
        $nota->valor = $request->input('valor');  // Obtener el score directamente
        $nota->tematica_id = $request->input('tematica_id');  // Obtener el tematica_id directamente
        $nota->player_id = $request->input('player_id');  // Obtener el player_id directamente
        $nota->save();

        // Retornar una respuesta exitosa
        return response()->json([
            'message' => 'Gracias por calificar!',
            'calificacion' => $nota  // Retornar la calificación recién guardada
        ], 201);
    }
}
