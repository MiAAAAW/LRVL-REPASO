<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->esEstudiante()) {
            return redirect()->route('habitaciones.index');
        } elseif ($user->esPropietario()) {
            return redirect()->route('propietario.habitaciones');
        }
        
        abort(403, 'Tipo de usuario no válido');
    }
}
