<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Muestra la lista de libros junto a sus categorías.
     */
    public function index()
    {
        $libros = Libro::with('categoria')->get();
        $categorias = Categoria::all();
        return view('libros.index', compact('libros', 'categorias'));
    }

    /**
     * Guarda un nuevo libro en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'idioma' => 'required|string|max:50',
            'autor' => 'required|string|max:100',
            'editorial' => 'required|string|max:100',
        ]);

        Libro::create($request->only(['titulo', 'categoria_id', 'idioma', 'autor', 'editorial']));

        return redirect()->back()->with('success', 'Libro agregado correctamente.');
    }

    /**
     * Actualiza un libro existente.
     */
    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'idioma' => 'required|string|max:50',
            'autor' => 'required|string|max:100',
            'editorial' => 'required|string|max:100',
        ]);

        $libro->update($request->only(['titulo', 'categoria_id', 'idioma', 'autor', 'editorial']));

        return redirect()->back()->with('success', "El libro '{$libro->titulo}' fue actualizado correctamente.");
    }

    /**
     * Elimina un libro del sistema.
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();

        return redirect()->back()->with('success', "El libro '{$libro->titulo}' fue eliminado correctamente.");
    }
}
