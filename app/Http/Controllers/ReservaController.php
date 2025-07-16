<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        // Solo estudiantes pueden reservar
        if (!Auth::user()->esEstudiante()) {
            abort(403, 'Solo estudiantes pueden hacer reservas');
        }

        $request->validate([
            'id_habitacion' => 'required|exists:habitaciones,id_habitacion',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $habitacion = Habitacion::findOrFail($request->id_habitacion);
        
        // Verificar si ya está reservada
        $reservaExistente = Reserva::where('id_habitacion', $habitacion->id_habitacion)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();
            
        if ($reservaExistente) {
            return back()->with('error', 'La habitación ya está reservada.');
        }

        // Crear reserva
        $reserva = Reserva::create([
            'id_estudiante' => Auth::id(),
            'id_habitacion' => $habitacion->id_habitacion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'pendiente'
        ]);

        // Actualizar estado de habitación
        $habitacion->update(['estado' => 'reservada']);

        return redirect()->route('estudiante.reservas')
            ->with('success', 'Reserva realizada correctamente');
    }

    public function misReservas()
    {
        // Solo estudiantes pueden ver sus reservas
        if (!Auth::user()->esEstudiante()) {
            abort(403, 'Solo estudiantes pueden ver reservas');
        }

        // Actualizar reservas vencidas
        $hoy = Carbon::today();
        Reserva::where('fecha_fin', '<', $hoy)
            ->where('estado', 'confirmada')
            ->update(['estado' => 'finalizada']);

        $reservas = Reserva::with(['habitacion.fotos'])
            ->where('id_estudiante', Auth::id())
            ->latest()
            ->get();
            
        return view('estudiante.reservas', compact('reservas'));
    }
}
