@extends('layouts.app')

@section('title', 'Iniciar Sesión - RoomMatch')

@push('styles')
<style>
    body {
        height: 100vh;
        background: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .login-container {
        display: flex;
        width: 95%;
        max-width: 1200px;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    }

    .left-panel {
        width: 50%;
        background: url('/images/Login.png') center/cover no-repeat;
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
        padding: 2rem;
        color: white;
        position: relative;
    }

    .left-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .left-text {
        position: relative;
        z-index: 2;
    }

    .left-text h3 {
        font-size: 1.7rem;
        font-weight: 600;
        color: #fff;
    }

    .right-panel {
        width: 50%;
        padding: 3rem;
        position: relative;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: bold;
        font-size: 1.2rem;
        color: #1a1a2e;
    }

    .logo i {
        color: #8a2be2;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .input-group-text {
        background-color: #eaeaea;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-right: none;
        border-radius: 0.75rem 0 0 0.75rem;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-left: none;
        border-radius: 0 0.75rem 0.75rem 0;
        background-color: #eaf1ff;
    }

    .btn-login {
        background-color: var(--primary);
        color: white;
        font-weight: 600;
        font-size: 1rem;
        padding: 0.75rem;
        border: none;
        border-radius: 1.5rem;
        width: 100%;
        cursor: pointer;
        margin-top: 1rem;
    }

    .btn-login:hover {
        background-color: #b21395;
    }

    .links {
        font-size: 0.9rem;
        text-align: center;
        margin-top: 1rem;
    }

    .links a {
        color: var(--primary);
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="left-panel">
        <div class="left-text">
            <h3>Hola !!!! <br>Bienvenidos a ROOMMATCH</h3>
        </div>
    </div>

    <div class="right-panel">
        <div class="top-bar">
            <div class="logo">
                <i class="fas fa-home"></i> ROOMMATCH
            </div>
            <div class="lang-btn">ES <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i></div>
        </div>

        <h1>Hola Bienvenido</h1>
        <p>Ingrese como Estudiante/Propietario</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="correo">Correo electrónico</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="correo" id="correo" class="form-control" 
                           placeholder="Correo" value="{{ old('correo') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" 
                           placeholder="Contraseña" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login">Ingresar</button>
            
            <div class="links">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="links">
                ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a>
            </div>
        </form>
    </div>
</div>
@endsection
