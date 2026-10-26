@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar curso</h2>
        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
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
        <form action="{{ route('courses.update', data_get($course, 'id')) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="course_number" class="form-label">Número del curso</label>
                <input type="text" name="course_number" id="course_number" class="form-control" value="{{ old('course_number', data_get($course, 'course_number', data_get($course, 'number', ''))) }}" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="day" class="form-label">Día</label>
                <input type="text" name="day" id="day" class="form-control" value="{{ old('day', data_get($course, 'day', '')) }}" maxlength="255">
            </div>
            <div class="mb-3">
                <label for="area_id" class="form-label">ID del área</label>
                <input type="number" name="area_id" id="area_id" class="form-control" value="{{ old('area_id', data_get($course, 'area_id', '')) }}" min="1">
            </div>
            <div class="mb-3">
                <label for="training_center_id" class="form-label">ID del centro de formación</label>
                <input type="number" name="training_center_id" id="training_center_id" class="form-control" value="{{ old('training_center_id', data_get($course, 'training_center_id', '')) }}" min="1">
            </div>
            <button type="submit" class="btn btn-success">Actualizar curso</button>
        </form>
    </div>
@endsection
