<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\Libro;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::with(['cliente', 'libro'])->get();
        $clientes = Cliente::all();
        $libros = Libro::all();

        return view('prestamo.index', compact('prestamos', 'clientes', 'libros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'libro_id' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date',
            'estado' => 'required|in:Prestado,Devuelto',
        ]);

        $prestamo = Prestamo::create($request->all());

        // Actualizar estado del libro
        $libro = Libro::find($prestamo->libro_id);
        if ($libro) {
            $libro->estado = ($prestamo->estado === 'Prestado') ? 'Prestado' : 'Disponible';
            $libro->save();
        }

        return redirect()->route('prestamo.index')->with('success', 'Préstamo registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $prestamo = Prestamo::findOrFail($id);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'libro_id' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date',
            'estado' => 'required|in:Prestado,Devuelto',
        ]);

        $prestamo->update($request->all());

        // Actualizar estado del libro
        $libro = Libro::find($prestamo->libro_id);
        if ($libro) {
            $libro->estado = ($prestamo->estado === 'Prestado') ? 'Prestado' : 'Disponible';
            $libro->save();
        }

        return redirect()->route('prestamo.index')->with('success', 'Préstamo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        // Liberar libro si existe
        $libro = Libro::find($prestamo->libro_id);
        if ($libro) {
            $libro->estado = 'Disponible';
            $libro->save();
        }

        $prestamo->delete();

        return redirect()->route('prestamo.index')->with('success', 'Préstamo eliminado y libro disponible.');
    }
}
