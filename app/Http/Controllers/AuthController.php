<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        // Buscar usuario por correo
        $usuario = User::where('correo', $request->correo)->first();

        if ($usuario && $request->contrasena === $usuario->contraseña) {
            Auth::login($usuario);
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'correo' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'contrasena' => 'required|string|min:6',
            'tipo_usuario' => 'required|in:estudiante,propietario',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contraseña' => $request->contrasena, // Texto plano como en el original
            'tipo_usuario' => $request->tipo_usuario,
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
