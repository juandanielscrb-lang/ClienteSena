@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar área</h2>
        <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
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
        <form action="{{ route('areas.update', data_get($area, 'id')) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', data_get($area, 'name', data_get($area, 'area_name', data_get($area, 'area', '')))) }}" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', data_get($area, 'description', '')) }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Actualizar área</button>
        </form>
    </div>
@endsection
