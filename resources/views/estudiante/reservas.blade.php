@extends('layouts.app')

@section('title', 'Mis Reservas - RoomMatch')

@push('styles')
<style>
    body {
        background-image: url('/images/IMAGEN_CUARTO3.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0; 
        left: 0;
        width: 100%; 
        height: 100%;
        background-color: rgba(0, 0, 0, 0.25);
        z-index: -1;
    }

    .reserva-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .reserva-card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: linear-gradient(90deg, #6610f2, #d63384);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 1rem 1.5rem;
        border: none;
    }

    .habitacion-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .badge-confirmada { 
        background-color: #28a745; 
        color: white;
    }
    
    .badge-finalizada { 
        background-color: #6c757d; 
        color: white;
    }
    
    .badge-pendiente { 
        background-color: #ffc107; 
        color: #000;
    }
    
    .badge-cancelada { 
        background-color: #dc3545; 
        color: white;
    }

    .btn-calificar { 
        background-color: #ffc107; 
        color: #000; 
        border-radius: 20px; 
        font-weight: 500; 
        border: none;
    }
    
    .btn-calificar:hover {
        background-color: #e0a800;
        color: #000;
    }
    
    .btn-ver { 
        background-color: #17a2b8; 
        color: white; 
        border-radius: 20px; 
        font-weight: 500; 
        border: none;
    }
    
    .btn-ver:hover {
        background-color: #138496;
        color: white;
    }

    .icono { 
        width: 22px; 
        margin-right: 8px; 
    }

    .progreso {
        height: 8px;
        background-color: #e9ecef;
        border-radius: 50px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .progreso-barra {
        height: 100%;
        background: linear-gradient(to right, #00c9ff, #92fe9d);
        transition: width 0.5s ease-in-out;
    }

    .header-reservas {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .info-icon {
        width: 20px;
        text-align: center;
        margin-right: 10px;
    }

    .precio-destacado {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
    }

    .duracion-badge {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        display: inline-block;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="header-reservas">
    <div class="container">
        <div class="text-center text-white">
            <h2><i class="fas fa-calendar-check text-warning"></i> Mis Reservas</h2>
            <p class="text-light mb-0">Explora tu historial de reservas realizadas</p>
        </div>
    </div>
</div>

<div class="container">
    @if($reservas->count() > 0)
        @foreach($reservas as $reserva)
            <div class="reserva-card">
                @if($reserva->habitacion->primera_foto)
                    <img src="{{ $reserva->habitacion->primera_foto }}" 
                         alt="Foto habitación" class="habitacion-img">
                @endif

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bed"></i> {{ $reserva->habitacion->titulo }}
                    </h5>
                </div>
                
                <div class="card-body">
                    <!-- Barra de progreso -->
                    <div class="progreso mb-3">
                        <div class="progreso-barra" style="width: {{ $reserva->progreso_porcentaje }}%;"></div>
                    </div>

                    <!-- Duración destacada -->
                    <div class="text-center mb-3">
                        <span class="duracion-badge">
                            <i class="fas fa-clock"></i> {{ $reserva->duracion_dias }} días reservados
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt text-danger info-icon"></i>
                                <strong>Ubicación:</strong> {{ $reserva->habitacion->ubicacion }}
                            </div>

                            <div class="info-item">
                                <i class="fas fa-money-bill-wave text-success info-icon"></i>
                                <strong>Precio:</strong> 
                                <span class="precio-destacado">S/. {{ number_format($reserva->habitacion->precio, 2) }}</span>
                            </div>

                            <div class="info-item">
                                <i class="fas fa-calendar-day text-info info-icon"></i>
                                <strong>Desde:</strong> {{ $reserva->fecha_inicio->format('d/m/Y') }}
                            </div>

                            <div class="info-item">
                                <i class="fas fa-calendar-check text-warning info-icon"></i>
                                <strong>Hasta:</strong> {{ $reserva->fecha_fin->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-user text-primary info-icon"></i>
                                <strong>Propietario:</strong> {{ $reserva->habitacion->propietario->nombre }}
                            </div>

                            <div class="info-item">
                                <i class="fas fa-file-signature text-secondary info-icon"></i>
                                <strong>Contrato:</strong> {{ ucfirst($reserva->habitacion->tipo_contrato) }}
                            </div>

                            <div class="info-item">
                                <i class="fas fa-flag-checkered text-primary info-icon"></i>
                                <strong>Estado:</strong>
                                <span class="badge 
                                    @if($reserva->estado == 'confirmada') badge-confirmada
                                    @elseif($reserva->estado == 'finalizada') badge-finalizada  
                                    @elseif($reserva->estado == 'pendiente') badge-pendiente
                                    @else badge-cancelada
                                    @endif">
                                    @switch($reserva->estado)
                                        @case('confirmada')
                                            <i class="fas fa-check"></i> Confirmada
                                            @break
                                        @case('finalizada')
                                            <i class="fas fa-flag-checkered"></i> Finalizada
                                            @break
                                        @case('pendiente')
                                            <i class="fas fa-hourglass-half"></i> Pendiente
                                            @break
                                        @default
                                            <i class="fas fa-times"></i> {{ ucfirst($reserva->estado) }}
                                    @endswitch
                                </span>
                            </div>

                            @if($reserva->precio_total)
                                <div class="info-item">
                                    <i class="fas fa-calculator text-success info-icon"></i>
                                    <strong>Total:</strong> 
                                    <span class="precio-destacado">S/. {{ number_format($reserva->precio_total, 2) }}</span>
                                </div>
                            @endif

                            @if($reserva->esta_activa)
                                <div class="alert alert-success mt-2">
                                    <i class="fas fa-home"></i> <strong>¡Reserva activa!</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('calificaciones.create', ['id_habitacion' => $reserva->habitacion->id_habitacion]) }}" 
                           class="btn btn-sm btn-calificar me-2">
                            <i class="fas fa-star"></i> Calificar
                        </a>
                        <a href="{{ route('calificaciones.index', ['habitacion' => $reserva->habitacion->id_habitacion]) }}" 
                           class="btn btn-sm btn-ver">
                            <i class="fas fa-eye"></i> Ver Calificaciones
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <div class="reserva-card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-times fa-5x text-muted mb-3"></i>
                    <h3>No tienes reservas</h3>
                    <p class="text-muted">Explora las habitaciones disponibles y haz tu primera reserva.</p>
                    <a href="{{ route('estudiante.habitaciones') }}" class="btn btn-primary btn-rounded">
                        <i class="fas fa-search"></i> Ver Habitaciones
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
