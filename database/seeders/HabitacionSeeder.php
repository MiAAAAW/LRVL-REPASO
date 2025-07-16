<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Habitacion;
use App\Models\FotoHabitacion;
use App\Models\User;

class HabitacionSeeder extends Seeder
{
    public function run()
    {
        // Obtener propietarios
        $propietarios = User::where('tipo_usuario', 'propietario')->get();

        if ($propietarios->count() == 0) {
            echo "⚠️ No hay propietarios creados. Ejecuta UserSeeder primero.\n";
            return;
        }

        $habitaciones = [
            [
                'titulo' => 'Habitación céntrica con baño privado',
                'descripcion' => 'Cómoda habitación amoblada en el centro de la ciudad, incluye baño privado, escritorio, closet y WiFi.',
                'ubicacion' => 'Centro de Lima, Cercado',
                'precio' => 450.00,
                'tipo_contrato' => 'mensual'
            ],
            [
                'titulo' => 'Cuarto cerca de universidades',
                'descripcion' => 'Habitación ideal para estudiantes, cerca de la UNI y UNMSM, incluye servicios básicos.',
                'ubicacion' => 'Rímac, Lima',
                'precio' => 350.00,
                'tipo_contrato' => 'semestral'
            ],
            [
                'titulo' => 'Habitación amplia con terraza',
                'descripcion' => 'Habitación con terraza privada, muy iluminada, incluye cable, internet y agua caliente.',
                'ubicacion' => 'San Miguel, Lima',
                'precio' => 500.00,
                'tipo_contrato' => 'mensual'
            ]
        ];

        foreach ($habitaciones as $index => $hab) {
            $propietario = $propietarios->random();
            
            $habitacion = Habitacion::create([
                'id_propietario' => $propietario->id_usuario,
                'titulo' => $hab['titulo'],
                'descripcion' => $hab['descripcion'],
                'ubicacion' => $hab['ubicacion'],
                'precio' => $hab['precio'],
                'tipo_contrato' => $hab['tipo_contrato'],
                'estado' => 'disponible'
            ]);

            // Agregar foto de ejemplo
            FotoHabitacion::create([
                'id_habitacion' => $habitacion->id_habitacion,
                'url_foto' => 'images/HABITACIONNUEVA.jpg'
            ]);
        }

        echo "✅ Habitaciones de ejemplo creadas exitosamente\n";
    }
}
