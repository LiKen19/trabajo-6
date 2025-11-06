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
        $total_clientes = Cliente::count();
        $total_libros_disponibles = Libro::where('estado', 'Disponible')->count();
        $total_prestamos_activos = Prestamo::where('estado', 'Prestado')->count();
        $total_libros = Libro::count();
        
        // Variables para los modales
        $categorias = Categoria::all();
        $clientes = Cliente::all();
        $libros_disponibles = Libro::where('estado', 'Disponible')->get(); // 👈 USAR SOLO ESTA

        return view('dashboard', compact(
            'total_clientes',
            'total_libros_disponibles',
            'total_prestamos_activos',
            'total_libros',
            'categorias',
            'clientes',
            'libros_disponibles'  // 👈 UNA SOLA VARIABLE
        ));
    }
}