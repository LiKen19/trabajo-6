<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestamo;
use Carbon\Carbon;

class PrestamoSeeder extends Seeder
{
    public function run()
    {
        $prestamos = [
            [
                'cliente_id' => 1,
                'libro_id' => 3,
                'fecha_prestamo' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'fecha_devolucion' => null,
                'estado' => 'Prestado',
            ],
            [
                'cliente_id' => 2,
                'libro_id' => 7,
                'fecha_prestamo' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'fecha_devolucion' => null,
                'estado' => 'Prestado',
            ],
            [
                'cliente_id' => 3,
                'libro_id' => 11,
                'fecha_prestamo' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'fecha_devolucion' => null,
                'estado' => 'Prestado',
            ],
            [
                'cliente_id' => 4,
                'libro_id' => 17,
                'fecha_prestamo' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'fecha_devolucion' => null,
                'estado' => 'Prestado',
            ],
            [
                'cliente_id' => 5,
                'libro_id' => 1,
                'fecha_prestamo' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'fecha_devolucion' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'estado' => 'Devuelto',
            ],
            [
                'cliente_id' => 6,
                'libro_id' => 4,
                'fecha_prestamo' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'fecha_devolucion' => Carbon::now()->subDays(8)->format('Y-m-d'),
                'estado' => 'Devuelto',
            ],
            [
                'cliente_id' => 7,
                'libro_id' => 8,
                'fecha_prestamo' => Carbon::now()->subDays(25)->format('Y-m-d'),
                'fecha_devolucion' => Carbon::now()->subDays(12)->format('Y-m-d'),
                'estado' => 'Devuelto',
            ],
            [
                'cliente_id' => 8,
                'libro_id' => 12,
                'fecha_prestamo' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'fecha_devolucion' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'estado' => 'Devuelto',
            ],
        ];

        foreach ($prestamos as $prestamo) {
            Prestamo::create($prestamo);
        }
    }
}