<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitacionController extends Controller
{
    public function index()
    {
        // Vista para estudiantes - ver todas las habitaciones disponibles
        $habitaciones = Habitacion::with(['propietario', 'fotos'])
            ->disponibles()
            ->latest('fecha_publicacion')
            ->get();
            
        return view('habitaciones.index', compact('habitaciones'));
    }

    public function show(Habitacion $habitacion)
    {
        $habitacion->load(['propietario', 'fotos', 'calificaciones.estudiante']);
        return view('habitaciones.show', compact('habitacion'));
    }
}
