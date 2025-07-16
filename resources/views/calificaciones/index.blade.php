@extends('layouts.app')

@section('title', 'Calificaciones - RoomMatch')

@push('styles')
<style>
    body {
        background: linear-gradient(to right, #e0c3fc, #8ec5fc);
        min-height: 100vh;
    }

    .calificaciones-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        margin: 30px auto;
        max-width: 1200px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
    }

    .page-header h2 {
        font-weight: bold;
        color: #6a1b9a;
        margin-bottom: 10px;
    }

    .page-header i {
        color: #f39c12;
        margin-right: 10px;
    }

    .filtros {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .filtros label {
        font-weight: bold;
        color: #495057;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .table thead th {
        background-color: #6a1b9a;
        color: white;
        text-align: center;
        border: none;
        font-weight: 600;
        padding: 15px 10px;
    }

    .table tbody td {
        text-align: center;
        vertical-align: middle;
        padding: 15px 10px;
        border-bottom: 1px solid #e9ecef;
    }

    .table tbody tr:hover {
        background-color: #f3e5f5;
        transition: all 0.2s ease-in-out;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .estrella {
        color: #f1c40f;
        font-size: 1.3rem;
        margin: 0 1px;
    }

    .btn-volver, .btn-salir {
        border-radius: 20px;
        font-weight: bold;
        padding: 10px 20px;
        margin: 5px;
        transition: all 0.3s ease;
    }

    .btn-volver {
        background-color: #6c757d;
        color: white;
        border: none;
    }

    .btn-volver:hover {
        background-color: #545b62;
        transform: translateY(-2px);
        color: white;
    }

    .btn-salir {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-salir:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        color: white;
    }

    .comentario-cell {
        max-width: 300px;
        text-align: left;
    }

    .comentario-texto {
        max-height: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .fecha-cell {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .habitacion-cell {
        font-weight: 600;
        color: #495057;
    }

    .no-calificaciones {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .no-calificaciones i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #dee2e6;
    }

    .stats-row {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="calificaciones-container">
        <div class="page-header">
            <h2><i class="fas fa-star"></i> Calificaciones Recibidas</h2>
            <p class="text-muted mb-0">Revisa las opiniones de los huéspedes sobre las habitaciones</p>
        </div>

        <!-- Estadísticas -->
        @if($calificaciones->count() > 0)
            <div class="stats-row">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number">{{ $calificaciones->count() }}</span>
                            <span class="stat-label">Total Calificaciones</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number">{{ number_format($calificaciones->avg('puntaje'), 1) }}</span>
                            <span class="stat-label">Promedio General</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number">{{ $calificaciones->where('puntaje', '>=', 4)->count() }}</span>
                            <span class="stat-label">Calificaciones 4-5⭐</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <span class="stat-number">{{ $habitaciones->count() }}</span>
                            <span class="stat-label">Habitaciones Calificadas</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtro por habitación -->
        <div class="filtros">
            <form method="GET" class="row align-items-end">
                <div class="col-md-8">
                    <label class="form-label">Filtrar por habitación:</label>
                    <select name="habitacion" class="form-select" onchange="this.form.submit()">
                        <option value="">📋 Todas las habitaciones</option>
                        @foreach($habitaciones as $h)
                            <option value="{{ $h->id_habitacion }}" 
                                    {{ $habitacionId == $h->id_habitacion ? 'selected' : '' }}>
                                🏠 {{ $h->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <noscript>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </noscript>
                </div>
            </form>
        </div>

        <!-- Tabla de calificaciones -->
        @if($calificaciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>🏠 Habitación</th>
                            <th>⭐ Puntaje</th>
                            <th>💭 Comentario</th>
                            <th>📅 Fecha</th>
                            <th>👤 Estudiante</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($calificaciones as $index => $calificacion)
                        <tr>
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td class="habitacion-cell">{{ $calificacion->habitacion->titulo }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <= $calificacion->puntaje)
                                            <i class="fas fa-star estrella"></i>
                                        @else
                                            <i class="far fa-star estrella" style="color: #ddd;"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2 text-muted">({{ $calificacion->puntaje }}/5)</span>
                                </div>
                            </td>
                            <td class="comentario-cell">
                                <div class="comentario-texto" title="{{ $calificacion->comentario }}">
                                    {{ $calificacion->comentario }}
                                </div>
                            </td>
                            <td class="fecha-cell">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $calificacion->created_at->format('d/m/Y') }}
                                <br>
                                <small>{{ $calificacion->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <i class="fas fa-user-graduate text-primary"></i>
                                {{ $calificacion->estudiante->nombre }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-calificaciones">
                <i class="fas fa-star-half-alt"></i>
                <h4>No hay calificaciones disponibles</h4>
                <p>{{ $habitacionId ? 'Esta habitación aún no tiene calificaciones.' : 'Aún no se han recibido calificaciones.' }}</p>
                @if($habitacionId)
                    <a href="{{ route('calificaciones.index') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> Ver Todas las Calificaciones
                    </a>
                @endif
            </div>
        @endif

        <!-- Botones de navegación -->
        <div class="text-center mt-4">
            @auth
                @if(Auth::user()->esEstudiante())
                    <a href="{{ route('estudiante.reservas') }}" class="btn btn-volver">
                        <i class="fas fa-arrow-left"></i> Volver a Mis Reservas
                    </a>
                @elseif(Auth::user()->esPropietario())
                    <a href="{{ route('propietario.habitaciones') }}" class="btn btn-volver">
                        <i class="fas fa-arrow-left"></i> Volver a Mis Habitaciones
                    </a>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tooltip para comentarios largos
    document.addEventListener('DOMContentLoaded', function() {
        const comentarios = document.querySelectorAll('.comentario-texto');
        
        comentarios.forEach(comentario => {
            if (comentario.scrollHeight > comentario.clientHeight) {
                comentario.style.cursor = 'pointer';
                comentario.addEventListener('click', function() {
                    if (this.style.maxHeight === 'none') {
                        this.style.maxHeight = '60px';
                        this.style.overflow = 'hidden';
                    } else {
                        this.style.maxHeight = 'none';
                        this.style.overflow = 'visible';
                    }
                });
            }
        });
    });
    
    // Auto-submit del filtro
    document.querySelector('select[name="habitacion"]').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endpush
