@extends('layouts.app')

@section('title', 'Habitaciones Disponibles - RoomMatch')

@push('styles')
<style>
    .card {
        margin-bottom: 20px;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .card-body h5 {
        font-weight: 600;
        color: var(--dark);
    }

    .btn-reservar {
        background-color: var(--primary);
        color: white;
        border-radius: 20px;
        padding: 8px 20px;
        transition: background-color 0.3s;
        border: none;
    }

    .btn-reservar:hover {
        background-color: #b21395;
        color: white;
    }

    .precio {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
    }

    .ubicacion {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .propietario {
        color: var(--secondary);
        font-weight: 500;
    }

    .welcome-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
    }
</style>
@endpush

@section('content')
<div class="welcome-header">
    <div class="container">
        <div class="text-center">
            <h2><i class="fas fa-user-graduate"></i> Bienvenido, {{ Auth::user()->nombre }}</h2>
            <p class="mb-0">Encuentra la habitación perfecta para ti</p>
        </div>
    </div>
</div>

<div class="container">
    @if($habitaciones->count() > 0)
        <div class="row">
            @foreach($habitaciones as $habitacion)
                <div class="col-md-4">
                    <div class="card">
                        @if($habitacion->primera_foto)
                            <img src="{{ $habitacion->primera_foto }}" class="card-img-top" 
                                 alt="Foto de {{ $habitacion->titulo }}">
                        @else
                            <img src="/images/placeholder.png" class="card-img-top" 
                                 alt="Sin foto disponible">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-home text-primary"></i> {{ $habitacion->titulo }}
                            </h5>
                            
                            <p class="precio">S/. {{ number_format($habitacion->precio, 2) }}</p>
                            
                            <p class="ubicacion">
                                <i class="fas fa-map-marker-alt"></i> {{ $habitacion->ubicacion }}
                            </p>
                            
                            <p class="propietario">
                                <i class="fas fa-user"></i> {{ $habitacion->propietario->nombre }}
                            </p>

                            @if($habitacion->promedio_calificacion > 0)
                                <div class="mb-2">
                                    <span class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $habitacion->promedio_calificacion)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                    <small class="text-muted">({{ $habitacion->total_calificaciones }} reseñas)</small>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('reservas.store') }}">
                                @csrf
                                <input type="hidden" name="id_habitacion" value="{{ $habitacion->id_habitacion }}">
                                
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label small">Fecha inicio:</label>
                                        <input type="date" name="fecha_inicio" class="form-control form-control-sm" 
                                               min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Fecha fin:</label>
                                        <input type="date" name="fecha_fin" class="form-control form-control-sm" 
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-reservar btn-block w-100 mt-3">
                                    <i class="fas fa-calendar-check"></i> Reservar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-bed fa-5x text-muted mb-3"></i>
            <h3>No hay habitaciones disponibles</h3>
            <p class="text-muted">Vuelve pronto para ver nuevas opciones.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Validar que fecha fin sea mayor que fecha inicio
    document.addEventListener('DOMContentLoaded', function() {
        const formsReserva = document.querySelectorAll('form');
        
        formsReserva.forEach(form => {
            const fechaInicio = form.querySelector('input[name="fecha_inicio"]');
            const fechaFin = form.querySelector('input[name="fecha_fin"]');
            
            if (fechaInicio && fechaFin) {
                fechaInicio.addEventListener('change', function() {
                    if (this.value) {
                        const minFechaFin = new Date(this.value);
                        minFechaFin.setDate(minFechaFin.getDate() + 1);
                        fechaFin.min = minFechaFin.toISOString().split('T')[0];
                    }
                });
            }
        });
    });
</script>
@endpush
