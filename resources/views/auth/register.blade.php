@extends('layouts.app')

@section('title', 'Registro - RoomMatch')

@push('styles')
<style>
    body {
        background: url('/images/IMAGEN_CUARTO4.png') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        height: 100vh;
        overflow-x: hidden;
    }

    .register-container {
        max-width: 500px;
        margin: 60px auto;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(12px);
        padding: 40px 35px;
        border-radius: 20px;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.1), 0 8px 16px rgba(0,0,0,0.25);
        animation: fadeIn 0.8s ease-in-out;
    }

    h3 {
        font-weight: 600;
        color: #6f42c1;
    }

    .form-group i {
        color: #6f42c1;
        transition: transform 0.3s ease;
    }

    .form-group:hover i {
        transform: scale(1.2);
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #D317B1;
        box-shadow: 0 0 5px rgba(211, 23, 177, 0.5);
    }

    .btn-register {
        background-color: #D317B1;
        color: white;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background-color: #c012a4;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .btn-secondary {
        border-radius: 25px;
        font-weight: 600;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-help {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 20px;
        background-color: #6610f2;
        color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        z-index: 999;
        border: none;
    }

    .btn-help:hover {
        background-color: #520dc2;
    }
</style>
@endpush

@section('content')
<div class="register-container">
    <div class="text-center mb-3">
        <img src="/images/LOGO_ROOMATCH.png" alt="RoomMatch" style="height: 60px;">
    </div>
    <h3 class="text-center mb-2">¡Únete a RoomMatch!</h3>
    <p class="text-center text-muted mb-4">Regístrate y encuentra o publica habitaciones fácilmente</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="nombre"><i class="fas fa-user me-1"></i>Nombre completo:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" 
                   value="{{ old('nombre') }}" required>
        </div>

        <div class="form-group">
            <label for="correo"><i class="fas fa-envelope me-1"></i>Correo electrónico:</label>
            <input type="email" name="correo" id="correo" class="form-control" 
                   value="{{ old('correo') }}" required>
        </div>

        <div class="form-group">
            <label for="contrasena"><i class="fas fa-lock me-1"></i>Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tipo_usuario"><i class="fas fa-users me-1"></i>Tipo de usuario:</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                <option value="estudiante" {{ old('tipo_usuario') == 'estudiante' ? 'selected' : '' }}>
                    Estudiante
                </option>
                <option value="propietario" {{ old('tipo_usuario') == 'propietario' ? 'selected' : '' }}>
                    Propietario
                </option>
            </select>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-register px-4">
                <i class="fas fa-user-plus"></i> Registrarse
            </button>
            <a href="{{ route('login') }}" class="btn btn-secondary ms-2">Cancelar</a>
        </div>
    </form>
</div>

<!-- Botón flotante de ayuda -->
<button class="btn btn-help" title="¿Necesitas ayuda?">
    <i class="fas fa-question"></i>
</button>
@endsection
