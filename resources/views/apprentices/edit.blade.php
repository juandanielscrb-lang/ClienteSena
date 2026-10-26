@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar aprendiz</h2>
        <a href="{{ route('apprentices.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
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
        <form action="{{ route('apprentices.update', data_get($apprentice, 'id')) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', data_get($apprentice, 'name', '')) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', data_get($apprentice, 'email', '')) }}" required>
            </div>
            <div class="mb-3">
                <label for="cell_number" class="form-label">Celular</label>
                <input type="text" name="cell_number" id="cell_number" class="form-control" value="{{ old('cell_number', data_get($apprentice, 'cell_number', '')) }}">
            </div>
            <button type="submit" class="btn btn-success">Actualizar aprendiz</button>
        </form>
    </div>
@endsection
