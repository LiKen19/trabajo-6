<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Categoria;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas principales
        $total_clientes = Cliente::count();
        $total_libros_disponibles = Libro::where('estado', 'Disponible')->count();
        $total_prestamos_activos = Prestamo::where('estado', 'Prestado')->count();

        // Datos para modales y listado
        $clientes = Cliente::all();
        $categorias = Categoria::all();
        $libros_disponibles = Libro::where('estado', 'Disponible')->get();
        $prestamos = Prestamo::with('cliente', 'libro')->get();

        return view('dashboard', compact(
            'total_clientes',
            'total_libros_disponibles',
            'total_prestamos_activos',
            'clientes',
            'categorias',
            'libros_disponibles',
            'prestamos'
        ));
    }
}
