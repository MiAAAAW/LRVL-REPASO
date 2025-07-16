@extends('layouts.app')

@section('title', 'Mis Habitaciones - RoomMatch')

@push('styles')
<style>
    .habitacion-card {
        border-radius: 12px;
        margin-bottom: 30px;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }

    .habitacion-card:hover {
        transform: translateY(-5px);
    }

    .habitacion-header {
        background: linear-gradient(90deg, #6f42c1, #8a63d2);
        color: white;
        padding: 15px 25px;
        font-size: 20px;
        font-weight: bold;
    }

    .habitacion-body {
        background-color: #fff;
        padding: 25px;
    }

    .info-icono {
        font-weight: bold;
        margin-right: 10px;
    }

    .badge-success {
        background-color: #28a745;
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 15px;
    }

    .badge-warning {
        background-color: #ffc107;
        font-size: 0.85rem;
        padding: 6px 12px;
        color: #000;
        border-radius: 15px;
    }

    .btn-publicar {
        background-color: #28a745;
        color: white;
        padding: 10px 25px;
        font-size: 16px;
        border-radius: 25px;
        margin: 10px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-publicar:hover {
        transform: scale(1.05);
        opacity: 0.9;
        color: white;
    }

    .estado-icon {
        margin-right: 5px;
    }

    .habitacion-img {
        width: 100%;
        height: auto;
        max-height: 300px;
        border-radius: 10px;
        margin-bottom: 15px;
        object-fit: cover;
    }

    .header-propietario {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
    }

    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .stats-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="header-propietario">
    <div class="container">
        <div class="text-center">
            <h1><i class="fas fa-bed"></i> Mis Habitaciones</h1>
            <p class="mb-0">Gestiona tus propiedades publicadas</p>
        </div>
    </div>
</div>

<div class="container">
    <!-- Estadísticas rápidas -->
    <div class="row">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon text-primary">
                    <i class="fas fa-home"></i>
                </div>
                <h3>{{ $habitaciones->count() }}</h3>
                <small class="text-muted">Total Habitaciones</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>{{ $habitaciones->where('estado', 'disponible')->count() }}</h3>
                <small class="text-muted">Disponibles</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon text-warning">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>{{ $habitaciones->where('estado', 'reservada')->count() }}</h3>
                <small class="text-muted">Reservadas</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon text-info">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>{{ $habitaciones->sum(function($h) { return $h->reservas->count(); }) }}</h3>
                <small class="text-muted">Total Reservas</small>
            </div>
        </div>
    </div>

    @if($habitaciones->count() > 0)
        @foreach($habitaciones as $habitacion)
            <div class="habitacion-card">
                <div class="habitacion-header">
                    <i class="fas fa-door-open"></i> {{ $habitacion->titulo }}
                </div>
                <div class="habitacion-body">
                    @if($habitacion->primera_foto)
                        <img src="{{ $habitacion->primera_foto }}" 
                             alt="Imagen de la habitación" 
                             class="habitacion-img">
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No hay fotos disponibles para esta habitación.
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <p>
                                <span class="info-icono">
                                    <i class="fas fa-map-marker-alt text-danger"></i> Ubicación:
                                </span>
                                {{ $habitacion->ubicacion }}
                            </p>

                            <p>
                                <span class="info-icono">
                                    <i class="fas fa-coins text-warning"></i> Precio:
                                </span>
                                S/. {{ number_format($habitacion->precio, 2) }}
                            </p>

                            <p>
                                <span class="info-icono">
                                    <i class="fas fa-file-contract text-info"></i> Tipo de contrato:
                                </span>
                                {{ ucfirst($habitacion->tipo_contrato) }}
                            </p>

                            <p>
                                <span class="info-icono">
                                    <i class="fas fa-align-left text-secondary"></i> Descripción:
                                </span>
                                {{ Str::limit($habitacion->descripcion, 150) }}
                            </p>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="text-center">
                                <p>
                                    <span class="info-icono">
                                        <i class="fas fa-clock text-primary"></i> Estado:
                                    </span>
                                </p>
                                @if(strtolower($habitacion->estado) === 'disponible')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle estado-icon"></i> Disponible
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-hourglass-half estado-icon"></i> {{ ucfirst($habitacion->estado) }}
                                    </span>
                                @endif

                                @if($habitacion->reservas->count() > 0)
                                    <div class="mt-3">
                                        <h6>Reservas:</h6>
                                        <span class="badge badge-info">
                                            {{ $habitacion->reservas->count() }} total
                                        </span>
                                    </div>
                                @endif

                                @if($habitacion->promedio_calificacion > 0)
                                    <div class="mt-3">
                                        <h6>Calificación:</h6>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $habitacion->promedio_calificacion)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">
                                            {{ number_format($habitacion->promedio_calificacion, 1) }}/5.0
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <i class="fas fa-home fa-5x text-muted mb-3"></i>
            <h3>No tienes habitaciones publicadas</h3>
            <p class="text-muted">Comienza publicando tu primera habitación.</p>
            <a href="{{ route('propietario.publicar') }}" class="btn btn-publicar">
                <i class="fas fa-plus-circle"></i> Publicar Primera Habitación
            </a>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('propietario.publicar') }}" class="btn btn-publicar">
            <i class="fas fa-plus-circle"></i> Publicar Nueva Habitación
        </a>
    </div>
</div>
@endsection
