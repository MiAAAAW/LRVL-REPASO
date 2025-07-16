<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            HabitacionSeeder::class,
        ]);
        
        echo "\n🎉 ¡Todos los seeders ejecutados exitosamente!\n";
        echo "📋 Usuarios de prueba creados:\n";
        echo "   - Propietario: propietario@test.com / 123456\n";
        echo "   - Estudiante: estudiante@test.com / 123456\n";
        echo "   - Carlos: carlos@test.com / 123456\n";
        echo "   - María: maria@test.com / 123456\n";
    }
}
