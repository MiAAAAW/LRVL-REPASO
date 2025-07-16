@extends('layouts.app')

@section('title', 'Publicar Habitación - RoomMatch')

@push('styles')
<style>
    body {
        background: url('/images/IMAGEN_CUARTO1.png') no-repeat center center fixed;
        background-size: cover;
    }

    .form-container {
        background: rgba(255, 255, 255, 0.95);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        max-width: 750px;
        margin: 60px auto;
        transition: transform 0.3s ease;
    }

    .form-container:hover {
        transform: translateY(-3px);
    }

    .form-title {
        text-align: center;
        font-weight: 600;
        margin-bottom: 30px;
        color: #343a40;
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
        font-size: 15px;
        margin-bottom: 15px;
    }

    .form-control:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 5px rgba(111, 66, 193, 0.5);
    }

    .form-control::placeholder {
        font-style: italic;
        color: #aaa;
    }

    .btn-guardar {
        background: linear-gradient(to right, #6f42c1, #b47bff);
        color: white;
        border-radius: 25px;
        font-weight: 500;
        padding: 10px 25px;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-guardar:hover {
        background: linear-gradient(to right, #5a33a8, #a868f8);
        color: white;
        transform: translateY(-2px);
    }

    .btn-cancelar {
        border-radius: 25px;
        padding: 10px 25px;
    }

    .icon-purple { color: #6f42c1; }
    .icon-blue   { color: #007bff; }
    .icon-orange { color: #fd7e14; }
    .icon-green  { color: #28a745; }
    .icon-teal   { color: #20c997; }

    .form-icon {
        margin-right: 8px;
        font-size: 16px;
    }

    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        cursor: pointer;
        width: 100%;
    }

    .file-upload-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
    }

    .file-upload-display {
        border: 2px dashed #6f42c1;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .file-upload-display:hover {
        background-color: #e9ecef;
        border-color: #5a33a8;
    }

    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 10px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <h3 class="form-title">
        <i class="fas fa-bed icon-purple"></i> Publicar Nueva Habitación
    </h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('propietario.publicar.store') }}" enctype="multipart/form-data" id="habitacionForm">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="titulo">
                    <i class="fas fa-heading form-icon icon-purple"></i> Título:
                </label>
                <input type="text" name="titulo" id="titulo" class="form-control" 
                       placeholder="Ej. Habitación céntrica con baño privado" 
                       value="{{ old('titulo') }}" required>
            </div>

            <div class="col-md-6">
                <label for="ubicacion">
                    <i class="fas fa-map-marker-alt form-icon icon-blue"></i> Ubicación:
                </label>
                <input type="text" name="ubicacion" id="ubicacion" class="form-control" 
                       placeholder="Ciudad, distrito o dirección" 
                       value="{{ old('ubicacion') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">
                <i class="fas fa-align-left form-icon icon-orange"></i> Descripción:
            </label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" 
                      placeholder="Describe servicios, tamaño, entorno, etc..." required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="precio">
                    <i class="fas fa-money-bill-wave form-icon icon-green"></i> Precio mensual (S/.):
                </label>
                <input type="number" name="precio" id="precio" step="0.01" class="form-control" 
                       placeholder="Ej. 350.00" value="{{ old('precio') }}" required>
            </div>

            <div class="col-md-6">
                <label for="tipo_contrato">
                    <i class="fas fa-file-signature form-icon icon-teal"></i> Tipo de contrato:
                </label>
                <select name="tipo_contrato" id="tipo_contrato" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="mensual" {{ old('tipo_contrato') == 'mensual' ? 'selected' : '' }}>
                        Mensual
                    </option>
                    <option value="semestral" {{ old('tipo_contrato') == 'semestral' ? 'selected' : '' }}>
                        Semestral
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="imagen">
                <i class="fas fa-image form-icon icon-purple"></i> Subir imagen (JPG, PNG):
            </label>
            <div class="file-upload-wrapper">
                <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png" required>
                <div class="file-upload-display" onclick="document.getElementById('imagen').click();">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                    <p class="mb-0">Haz clic aquí para seleccionar una imagen</p>
                    <small class="text-muted">Formatos: JPG, PNG (máx. 2MB)</small>
                    <div id="imagePreview"></div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-guardar">
                <i class="fas fa-save"></i> Guardar Habitación
            </button>
            <a href="{{ route('propietario.habitaciones') }}" class="btn btn-secondary btn-cancelar ms-2">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Preview de imagen
    document.getElementById('imagen').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="mt-3">
                        <img src="${e.target.result}" class="preview-image" alt="Preview">
                        <p class="text-success mt-2 mb-0">
                            <i class="fas fa-check"></i> ${file.name}
                        </p>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });

    // Validación del formulario
    document.getElementById('habitacionForm').addEventListener('submit', function(e) {
        const precio = document.getElementById('precio').value;
        
        if (precio <= 0) {
            e.preventDefault();
            alert('El precio debe ser mayor a 0');
            return false;
        }
        
        if (!document.getElementById('imagen').files[0]) {
            e.preventDefault();
            alert('Debe seleccionar una imagen');
            return false;
        }
    });

    // Formatear el precio mientras se escribe
    document.getElementById('precio').addEventListener('input', function(e) {
        let value = e.target.value;
        if (value && !isNaN(value)) {
            // Agregar formato visual si es necesario
        }
    });
</script>
@endpush
