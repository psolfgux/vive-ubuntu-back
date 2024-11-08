<?php

namespace App\Http\Controllers;

use App\Models\Tematica;
use App\Models\Carta;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CartaController extends Controller
{
    // Listar todas las cartas de una temática
    public function index(Tematica $tematica)
    {
        $cartas = $tematica->cartas()->get();
        return view('cartas.index', compact('cartas', 'tematica'));
    }

    // Mostrar formulario de creación
    public function create(Tematica $tematica)
    {
        return view('cartas.create', compact('tematica'));
    }

    // Guardar una nueva carta
    public function store(Request $request, $tematicaId)
    {
    // Validar datos
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
    ]);

    // Crear la nueva carta
    $carta = new Carta();
    $carta->titulo = $validated['titulo'];
    $carta->descripcion = $validated['descripcion'];
    $carta->tematica_id = $tematicaId; // Asumimos que tienes una relación con la temática
    $carta->save();

    return redirect()->route('tematicas.cartas.index', $tematicaId)->with('success', 'Carta creada exitosamente.');
}


    // Mostrar formulario de edición
    public function edit(Tematica $tematica, Carta $carta)
    {
        return view('cartas.edit', compact('carta', 'tematica'));
    }

    // Actualizar una carta existente
    public function update(Request $request, Tematica $tematica, Carta $carta)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required',
        ]);

        $carta->update($request->only('titulo', 'descripcion'));

        return redirect()->route('tematicas.cartas.index', $tematica)
            ->with('success', 'Carta actualizada con éxito.');
    }

    // Eliminar una carta
    public function destroy(Tematica $tematica, Carta $carta)
    {
        $carta->delete();

        return redirect()->route('tematicas.cartas.index', $tematica)
            ->with('success', 'Carta eliminada con éxito.');
    }

    // Importar cartas desde un archivo CSV
    public function import(Request $request, Tematica $tematica)
    {
        // Verifica si se ha subido un archivo CSV
        if ($request->hasFile('file')) {
            $file = $request->file('file');
    
            // Abrir el archivo para leer
            $handle = fopen($file, 'r');
            $header = true;
    
            // Leer línea por línea
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Saltar la primera fila si es el encabezado
                if ($header) {
                    $header = false;
                    continue;
                }
    
                // Obtener los datos de la fila
                $id = $row[0]; // ID de la carta
                $titulo = $row[2]; // Título de la carta
                $descripcion = $row[3]; // Descripción de la carta
    
                // Si el ID está presente, actualizamos la carta existente
                if ($id) {
                    $carta = Carta::where('id', $id)->where('tematica_id', $tematica->id)->first();
    
                    if ($carta) {
                        $carta->update([
                            'titulo' => $titulo,
                            'descripcion' => $descripcion,
                        ]);
                    }
                } else {
                    // Si no hay ID, creamos una nueva carta
                    Carta::create([
                        'tematica_id' => $tematica->id,
                        'titulo' => $titulo,
                        'descripcion' => $descripcion,
                    ]);
                }
            }
    
            fclose($handle);
    
            return redirect()->back()->with('success', 'Cartas importadas correctamente.');
        }
    
        return redirect()->back()->with('error', 'Error al cargar el archivo.');
    }
    

    // Exportar cartas a un archivo CSV
    public function export(Tematica $tematica)
    {
        // Filtrar las cartas según la temática
        $cartas = Carta::where('tematica_id', $tematica->id)->get();

        $response = new StreamedResponse(function() use ($cartas) {
            $handle = fopen('php://output', 'w');

            // Agregar los encabezados al CSV
            fputcsv($handle, ['ID', 'Temática ID', 'Título', 'Descripción']);

            // Iterar sobre los registros y agregarlos al CSV
            foreach ($cartas as $carta) {
                fputcsv($handle, [$carta->id, $carta->tematica_id, $carta->titulo, $carta->descripcion]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="cartas_tematica_'.$tematica->id.'.csv"');

        return $response;
    }

    public function showgame($tematicaId)
    {
        // Obtener todas las cartas que pertenezcan a la temática con el ID proporcionado
        $cartas = Carta::where('tematica_id', $tematicaId)->get();

        // Retornar los registros en formato JSON
        return response()->json($cartas);
    }

}
