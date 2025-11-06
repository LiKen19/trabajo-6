<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    public function run()
    {
        $libros = [
            [
                'titulo' => 'Cien años de soledad',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Gabriel García Márquez',
                'editorial' => 'Editorial Sudamericana',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El Principito',
                'categoria_id' => 6,
                'idioma' => 'Español',
                'autor' => 'Antoine de Saint-Exupéry',
                'editorial' => 'Salamandra',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => '1984',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'George Orwell',
                'editorial' => 'Debolsillo',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'Sapiens',
                'categoria_id' => 4,
                'idioma' => 'Español',
                'autor' => 'Yuval Noah Harari',
                'editorial' => 'Debate',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El código limpio',
                'categoria_id' => 5,
                'idioma' => 'Español',
                'autor' => 'Robert C. Martin',
                'editorial' => 'Anaya Multimedia',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Don Quijote de la Mancha',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Miguel de Cervantes',
                'editorial' => 'Real Academia Española',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Breve historia del tiempo',
                'categoria_id' => 3,
                'idioma' => 'Español',
                'autor' => 'Stephen Hawking',
                'editorial' => 'Crítica',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'Veinte poemas de amor',
                'categoria_id' => 7,
                'idioma' => 'Español',
                'autor' => 'Pablo Neruda',
                'editorial' => 'Seix Barral',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'La Odisea',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Homero',
                'editorial' => 'Gredos',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El arte de la guerra',
                'categoria_id' => 4,
                'idioma' => 'Español',
                'autor' => 'Sun Tzu',
                'editorial' => 'Obelisco',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Harry Potter y la piedra filosofal',
                'categoria_id' => 6,
                'idioma' => 'Español',
                'autor' => 'J.K. Rowling',
                'editorial' => 'Salamandra',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'El nombre de la rosa',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Umberto Eco',
                'editorial' => 'Lumen',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'La historia del arte',
                'categoria_id' => 8,
                'idioma' => 'Español',
                'autor' => 'E.H. Gombrich',
                'editorial' => 'Phaidon',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Python para todos',
                'categoria_id' => 5,
                'idioma' => 'Español',
                'autor' => 'Charles Severance',
                'editorial' => 'Independently Published',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Crónica de una muerte anunciada',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Gabriel García Márquez',
                'editorial' => 'Diana',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El alquimista',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Paulo Coelho',
                'editorial' => 'Planeta',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Los miserables',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Victor Hugo',
                'editorial' => 'Penguin Clásicos',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'El origen de las especies',
                'categoria_id' => 3,
                'idioma' => 'Español',
                'autor' => 'Charles Darwin',
                'editorial' => 'Alianza Editorial',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Rayuela',
                'categoria_id' => 1,
                'idioma' => 'Español',
                'autor' => 'Julio Cortázar',
                'editorial' => 'Alfaguara',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El mundo de Sofía',
                'categoria_id' => 2,
                'idioma' => 'Español',
                'autor' => 'Jostein Gaarder',
                'editorial' => 'Siruela',
                'estado' => 'Disponible',
            ],
        ];

        foreach ($libros as $libro) {
            Libro::create($libro);
        }
    }
}