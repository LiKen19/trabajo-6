<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\Libro;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    /**
     * Muestra todos los préstamos junto con los clientes y libros relacionados.
     */
    public function index()
    {
        $prestamos = Prestamo::with(['cliente', 'libro'])->get();
        $clientes = Cliente::all();
        $libros = Libro::all();

        return view('prestamo.index', compact('prestamos', 'clientes', 'libros'));
    }

    /**
     * Registra un nuevo préstamo en el sistema.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'libro_id' => 'required|integer|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|in:Prestado,Devuelto',
        ]);

        $prestamo = Prestamo::create($request->only([
            'cliente_id', 'libro_id', 'fecha_prestamo', 'fecha_devolucion', 'estado'
        ]));

        // Actualizar estado del libro
        $libro = Libro::find($prestamo->libro_id);
        if ($libro) {
            $this->actualizarEstadoLibro($libro, $prestamo->estado);
        }

        return redirect()->route('prestamo.index')->with('success', 'Préstamo registrado correctamente.');
    }

    /**
     * Actualiza un préstamo existente.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'libro_id' => 'required|integer|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|in:Prestado,Devuelto',
        ]);

        $prestamo->update($request->only([
            'cliente_id', 'libro_id', 'fecha_prestamo', 'fecha_devolucion', 'estado'
        ]));

        // Actualizar estado del libro
        $libro = Libro::find($prestamo->libro_id);
        if ($libro) {
            $this->actualizarEstadoLibro($libro, $prestamo->estado);
        }

        return redirect()->route('prestamo.index')->with('success', 'Préstamo actualizado correctamente.');
    }

    /**
     * Elimina un préstamo y libera el libro asociado.
     */
    public function destroy(Prestamo $prestamo)
    {
        $libro = Libro::find($prestamo->libro_id);
        if ($libro) {
            $this->actualizarEstadoLibro($libro, 'Disponible');
        }

        $prestamo->delete();

        return redirect()->route('prestamo.index')->with('success', 'Préstamo eliminado y libro disponible.');
    }

    /**
     * Cambia el estado de un libro según el préstamo.
     */
    private function actualizarEstadoLibro(Libro $libro, string $estado)
    {
        $libro->estado = ($estado === 'Prestado') ? 'Prestado' : 'Disponible';
        $libro->save();
    }
}
