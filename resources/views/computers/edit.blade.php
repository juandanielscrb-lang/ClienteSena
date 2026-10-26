@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Computador</h2>

        <form action="{{ route('computers.update', $computer['id'] ?? $computer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="number" class="form-label">Número de Computador:</label>
                <input type="text" class="form-control" name="number" id="number" value="{{ old('number', $computer['number'] ?? $computer->number) }}" required>
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Marca:</label>
                <input type="text" class="form-control" name="brand" id="brand" value="{{ old('brand', $computer['brand'] ?? $computer->brand) }}" required>
            </div>

            <!-- Mostrar imagen actual si la API la devuelve -->
            @if(isset($computer['imagen_url']) || isset($computer->imagen_url))
                <div class="mb-3">
                    <label class="form-label">Imagen Actual:</label><br>
                    <img src="{{ $computer['imagen_url'] ?? $computer->imagen_url }}" alt="Imagen computador" width="100" class="img-thumbnail">
                </div>
            @endif

            <div class="mb-3">
                <label for="imagen" class="form-label">Cambiar Imagen (Opcional):</label>
                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Computador</button>
            <a href="{{ route('computers.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection