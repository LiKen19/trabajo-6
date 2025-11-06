<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $clientes = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'dni' => '12345678',
                'telefono' => '987654321',
                'direccion' => 'Av. Principal 123',
                'correo' => 'juan.perez@email.com',
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'dni' => '23456789',
                'telefono' => '987654322',
                'direccion' => 'Jr. Los Olivos 456',
                'correo' => 'maria.gonzalez@email.com',
            ],
            [
                'nombre' => 'Pedro',
                'apellido' => 'Ramírez',
                'dni' => '34567890',
                'telefono' => '987654323',
                'direccion' => 'Calle Lima 789',
                'correo' => 'pedro.ramirez@email.com',
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'dni' => '45678901',
                'telefono' => '987654324',
                'direccion' => 'Av. Arequipa 321',
                'correo' => 'ana.martinez@email.com',
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'Fernández',
                'dni' => '56789012',
                'telefono' => '987654325',
                'direccion' => 'Jr. Cusco 654',
                'correo' => 'luis.fernandez@email.com',
            ],
            [
                'nombre' => 'Carmen',
                'apellido' => 'Torres',
                'dni' => '67890123',
                'telefono' => '987654326',
                'direccion' => 'Calle Puno 987',
                'correo' => 'carmen.torres@email.com',
            ],
            [
                'nombre' => 'Roberto',
                'apellido' => 'Silva',
                'dni' => '78901234',
                'telefono' => '987654327',
                'direccion' => 'Av. Brasil 147',
                'correo' => 'roberto.silva@email.com',
            ],
            [
                'nombre' => 'Lucía',
                'apellido' => 'Vargas',
                'dni' => '89012345',
                'telefono' => '987654328',
                'direccion' => 'Jr. Tacna 258',
                'correo' => 'lucia.vargas@email.com',
            ],
            [
                'nombre' => 'Diego',
                'apellido' => 'Rojas',
                'dni' => '90123456',
                'telefono' => '987654329',
                'direccion' => 'Calle Junín 369',
                'correo' => 'diego.rojas@email.com',
            ],
            [
                'nombre' => 'Patricia',
                'apellido' => 'Mendoza',
                'dni' => '01234567',
                'telefono' => '987654330',
                'direccion' => 'Av. Salaverry 741',
                'correo' => 'patricia.mendoza@email.com',
            ],
            [
                'nombre' => 'Fernando',
                'apellido' => 'Castro',
                'dni' => '11223344',
                'telefono' => '987654331',
                'direccion' => 'Jr. Ancash 852',
                'correo' => 'fernando.castro@email.com',
            ],
            [
                'nombre' => 'Sofía',
                'apellido' => 'Quispe',
                'dni' => '22334455',
                'telefono' => '987654332',
                'direccion' => 'Calle Ica 963',
                'correo' => 'sofia.quispe@email.com',
            ],
            [
                'nombre' => 'Miguel',
                'apellido' => 'Huamán',
                'dni' => '33445566',
                'telefono' => '987654333',
                'direccion' => 'Av. Venezuela 159',
                'correo' => 'miguel.huaman@email.com',
            ],
            [
                'nombre' => 'Elena',
                'apellido' => 'Paredes',
                'dni' => '44556677',
                'telefono' => '987654334',
                'direccion' => 'Jr. Ayacucho 357',
                'correo' => 'elena.paredes@email.com',
            ],
            [
                'nombre' => 'Jorge',
                'apellido' => 'Flores',
                'dni' => '55667788',
                'telefono' => '987654335',
                'direccion' => 'Calle Moquegua 486',
                'correo' => 'jorge.flores@email.com',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}