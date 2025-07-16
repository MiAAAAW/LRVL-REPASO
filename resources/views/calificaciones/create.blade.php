@extends('layouts.app')

@section('title', 'Calificar Habitación - RoomMatch')

@push('styles')
<style>
    body {
        background: url('/images/IMAGEN_CUARTO5.png') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
    }

    .calificar-container {
        max-width: 600px;
        margin: 60px auto;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.25);
        animation: fadeIn 1s ease;
    }

    h3 {
        font-weight: 600;
        color: #6f42c1;
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-group i {
        color: #6f42c1;
    }

    .btn-calificar {
        background-color: #D317B1;
        color: white;
        border-radius: 25px;
        font-weight: 600;
        padding: 10px 25px;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-calificar:hover {
        background-color: #b21395;
        color: white;
        transform: translateY(-2px);
    }

    .btn-secondary {
        border-radius: 25px;
        padding: 10px 25px;
    }

    .estrella {
        font-size: 30px;
        cursor: pointer;
        color: #ccc;
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .estrella:hover {
        color: #ffd700;
        transform: scale(1.2);
    }

    .estrella.checked {
        color: #ffd700;
    }

    .rating-container {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 15px;
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 5px rgba(111, 66, 193, 0.5);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .habitacion-info {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .puntaje-seleccionado {
        font-size: 1.2rem;
        font-weight: 600;
        color: #6f42c1;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="calificar-container">
    <div class="text-center mb-3">
        <img src="/images/LOGO_ROOMATCH.png" alt="RoomMatch" style="height: 60px;">
    </div>

    @if($habitacion)
        <div class="habitacion-info">
            <h4><i class="fas fa-bed"></i> {{ $habitacion->titulo }}</h4>
            <p class="mb-0">
                <i class="fas fa-map-marker-alt"></i> {{ $habitacion->ubicacion }} | 
                <i class="fas fa-user"></i> {{ $habitacion->propietario->nombre }}
            </p>
        </div>
    @endif

    <h3>Calificar Habitación</h3>
    
    @if ($errors->any())
        <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('calificaciones.store') }}">
        @csrf
        <input type="hidden" name="id_habitacion" value="{{ request('id_habitacion') }}">

        <!-- Puntaje con estrellas -->
        <div class="form-group">
            <label><strong>Tu calificación:</strong></label>
            <div class="rating-container">
                <input type="hidden" name="puntaje" id="puntaje" value="0">
                <div class="estrellas-container">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star estrella" onclick="setPuntaje({{ $i }})" data-rating="{{ $i }}"></i>
                    @endfor
                </div>
                <div class="puntaje-seleccionado" id="puntajeTexto">
                    Selecciona una calificación
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="comentario">
                <i class="fas fa-comment"></i> Tu comentario:
            </label>
            <textarea name="comentario" id="comentario" class="form-control" rows="4" 
                      placeholder="Comparte tu experiencia con esta habitación..." required>{{ old('comentario') }}</textarea>
            <small class="text-muted">Describe aspectos como limpieza, comodidad, ubicación, trato del propietario, etc.</small>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-calificar px-4">
                <i class="fas fa-paper-plane"></i> Enviar Calificación
            </button>
            <a href="{{ route('estudiante.reservas') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function setPuntaje(puntaje) {
        document.getElementById("puntaje").value = puntaje;
        
        const estrellas = document.querySelectorAll(".estrella");
        const textos = ['', 'Muy malo', 'Malo', 'Regular', 'Bueno', 'Excelente'];
        
        estrellas.forEach((estrella, index) => {
            estrella.classList.toggle("checked", index < puntaje);
        });
        
        document.getElementById("puntajeTexto").textContent = textos[puntaje] + ' (' + puntaje + '/5)';
    }

    // Efecto hover en estrellas
    document.addEventListener('DOMContentLoaded', function() {
        const estrellas = document.querySelectorAll('.estrella');
        
        estrellas.forEach((estrella, index) => {
            estrella.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                estrellas.forEach((s, i) => {
                    s.style.color = i < rating ? '#ffd700' : '#ccc';
                });
            });
        });

        document.querySelector('.estrellas-container').addEventListener('mouseleave', function() {
            const puntajeActual = parseInt(document.getElementById('puntaje').value);
            estrellas.forEach((s, i) => {
                s.style.color = i < puntajeActual ? '#ffd700' : '#ccc';
            });
        });
    });

    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const puntaje = document.getElementById('puntaje').value;
        if (puntaje == 0) {
            e.preventDefault();
            alert('Por favor selecciona una calificación con estrellas');
            return false;
        }
    });
</script>
@endpush
