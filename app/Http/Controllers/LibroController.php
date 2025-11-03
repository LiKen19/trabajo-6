<?php
namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::with('categoria')->get();
        $categorias = Categoria::all();
        return view('libros.index', compact('libros', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'idioma' => 'required',
            'autor' => 'required',
            'editorial' => 'required',
        ]);


        Libro::create($request->all());

        return redirect()->back()->with('success', 'Libro agregado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'idioma' => 'required',
            'autor' => 'required',
            'editorial' => 'required',
        ]);


        $libro = Libro::findOrFail($id);
        $libro->update($request->all());

        return redirect()->back()->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->delete();

        return redirect()->back()->with('success', 'Libro eliminado correctamente.');
    }
}
