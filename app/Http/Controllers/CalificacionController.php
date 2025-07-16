<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        // Solo estudiantes pueden calificar
        if (!Auth::user()->esEstudiante()) {
            abort(403, 'Solo estudiantes pueden calificar');
        }

        $habitacion = Habitacion::findOrFail($request->id_habitacion);
        
        return view('calificaciones.create', compact('habitacion'));
    }

    public function store(Request $request)
    {
        // Solo estudiantes pueden calificar
        if (!Auth::user()->esEstudiante()) {
            abort(403, 'Solo estudiantes pueden calificar');
        }

        $request->validate([
            'id_habitacion' => 'required|exists:habitaciones,id_habitacion',
            'puntaje' => 'required|integer|between:1,5',
            'comentario' => 'required|string|max:1000',
        ]);

        Calificacion::create([
            'id_estudiante' => Auth::id(),
            'id_habitacion' => $request->id_habitacion,
            'puntaje' => $request->puntaje,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('estudiante.reservas')
            ->with('success', 'Calificación enviada correctamente');
    }

    public function index(Request $request)
    {
        $habitacionId = $request->get('habitacion');
        
        $query = Calificacion::with(['habitacion', 'estudiante']);
        
        if ($habitacionId) {
            $query->where('id_habitacion', $habitacionId);
        }
        
        $calificaciones = $query->latest()->get();
        
        $habitaciones = Habitacion::has('calificaciones')
            ->select('id_habitacion', 'titulo')
            ->get();
            
        return view('calificaciones.index', compact('calificaciones', 'habitaciones', 'habitacionId'));
    }
}
