<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\FotoHabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropietarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->esPropietario()) {
                abort(403, 'Acceso denegado. Solo propietarios.');
            }
            return $next($request);
        });
    }

    public function habitaciones()
    {
        $habitaciones = Habitacion::with(['fotos', 'reservas'])
            ->where('id_propietario', Auth::id())
            ->latest()
            ->get();
            
        return view('propietario.habitaciones', compact('habitaciones'));
    }

    public function showPublicar()
    {
        return view('propietario.publicar');
    }

    public function publicar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'tipo_contrato' => 'required|in:mensual,semestral',
            'imagen' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $habitacion = Habitacion::create([
            'id_propietario' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'ubicacion' => $request->ubicacion,
            'precio' => $request->precio,
            'tipo_contrato' => $request->tipo_contrato,
            'estado' => 'disponible'
        ]);

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = 'images/' . $nombreImagen;
            
            // Mover imagen a public/images
            $imagen->move(public_path('images'), $nombreImagen);
            
            // Guardar en base de datos
            FotoHabitacion::create([
                'id_habitacion' => $habitacion->id_habitacion,
                'url_foto' => $rutaImagen
            ]);
        }

        return redirect()->route('propietario.habitaciones')
            ->with('success', 'Habitación publicada correctamente');
    }
}
