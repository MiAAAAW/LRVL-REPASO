<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear propietario de prueba
        User::create([
            'nombre' => 'Juan Propietario',
            'correo' => 'propietario@test.com',
            'contraseña' => '123456',
            'tipo_usuario' => 'propietario'
        ]);

        // Crear estudiante de prueba
        User::create([
            'nombre' => 'Ana Estudiante',
            'correo' => 'estudiante@test.com',
            'contraseña' => '123456',
            'tipo_usuario' => 'estudiante'
        ]);

        // Crear más usuarios de prueba
        User::create([
            'nombre' => 'Carlos Propietario',
            'correo' => 'carlos@test.com',
            'contraseña' => '123456',
            'tipo_usuario' => 'propietario'
        ]);

        User::create([
            'nombre' => 'María Estudiante',
            'correo' => 'maria@test.com',
            'contraseña' => '123456',
            'tipo_usuario' => 'estudiante'
        ]);

        echo "✅ Usuarios creados exitosamente\n";
    }
}
