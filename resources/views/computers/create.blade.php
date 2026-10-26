@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Registrar computador</h2>
        <a href="{{ route('computers.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form action="{{ route('computers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="number" class="form-label">Número de Computador:</label>
        <input type="text" class="form-control" name="number" id="number" value="{{ old('number') }}" required>
    </div>

    <div class="mb-3">
        <label for="brand" class="form-label">Marca:</label>
        <input type="text" class="form-control" name="brand" id="brand" value="{{ old('brand') }}" required>
    </div>

    <!-- Campo obligatorio para la imagen que subirá a Cloudinary -->
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen del Computador:</label>
        <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-success">Guardar Computador</button>
</form>
    </div>
@endsection
