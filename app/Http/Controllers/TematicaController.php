<?php

namespace App\Http\Controllers;

use App\Models\Tematica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TematicaController extends Controller
{
    // Mostrar todas las temáticas
    public function index()
    {
        $tematicas = Tematica::with('user')->get(); // Incluyendo usuario
        return view('tematicas.index', compact('tematicas'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('tematicas.create');
    }

    // Guardar nueva temática
    public function store(Request $request)
{
    // Validación de los campos
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'orden' => 'required|integer',
        'color' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Asegurarse que es 'image'
    ]);

    // Procesar la image si se sube una nueva
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('tematicas', 'public');
        $validated['image'] = $imagePath;
    }

    // Verificar si estamos editando una temática existente
    if ($request->filled('tematica_id')) {
        // Obtener la temática a editar
        $tematica = Tematica::findOrFail($request->tematica_id);

        // Mantener la image anterior si no se sube una nueva
        if (!$request->hasFile('image')) {
            $validated['image'] = $tematica->image; // Conservar la image existente
        }

        // Actualizar los datos de la temática
        $tematica->update($validated);

    } else {
        // Crear nueva temática
        $validated['user_id'] = auth()->id();
        Tematica::create($validated);
    }

    // Redirigir con un mensaje de éxito
    return redirect()->route('tematicas.index')->with('success', 'Temática guardada correctamente');
}



    public function edit(Tematica $tematica)
    {
        return view('tematicas.edit', compact('tematica'));
    }

    // Actualizar temática
public function update(Request $request, Tematica $tematica)
{
    // Validar los campos
    $request->validate([
        'titulo' => 'required|max:255',
        'descripcion' => 'required',
        'orden' => 'required|integer',
        'color' => 'required|string|max:7',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Asegúrate que el nombre es 'image'
    ]);

    // Procesar la image si se sube una nueva
    if ($request->hasFile('image')) {
        // Guardar la nueva image
        $imagePath = $request->file('image')->store('tematicas', 'public');

        // Si ya existe una image, podrías querer eliminar la anterior para no acumular archivos innecesarios
        if ($tematica->image) {
            Storage::disk('public')->delete($tematica->image);
        }

        // Actualizar el campo image con la nueva ruta
        $tematica->image = $imagePath;
    }

    // Actualizar los demás campos
    $tematica->update([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'orden' => $request->orden,
        'color' => $request->color,
    ]);

    // Guardar cambios
    $tematica->save();

    return redirect()->route('tematicas.index')->with('success', 'Temática actualizada con éxito');
}


    // Eliminar temática
    public function destroy(Tematica $tematica)
    {
        $tematica->delete();
        return redirect()->route('tematicas.index')->with('success', 'Temática eliminada con éxito');
    }

    public function all()
    {
        $tematicas = Tematica::all();
        return response()->json($tematicas);
    }

    public function tematicaid($id)
    {
        $tematica = Tematica::where('id', $id)->firstOrFail();
        return response()->json($tematica);
    }
}
