<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Ficción', 'descripcion' => 'Novelas y cuentos de ficción'],
            ['nombre' => 'No Ficción', 'descripcion' => 'Libros basados en hechos reales'],
            ['nombre' => 'Ciencia', 'descripcion' => 'Libros científicos y técnicos'],
            ['nombre' => 'Historia', 'descripcion' => 'Libros de historia y biografías'],
            ['nombre' => 'Tecnología', 'descripcion' => 'Programación y tecnología'],
            ['nombre' => 'Infantil', 'descripcion' => 'Libros para niños'],
            ['nombre' => 'Poesía', 'descripcion' => 'Colección de poemas'],
            ['nombre' => 'Arte', 'descripcion' => 'Libros sobre arte y cultura'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}