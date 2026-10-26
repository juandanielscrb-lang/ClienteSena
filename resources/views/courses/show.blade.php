@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalle del curso</h2>
        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <div class="card shadow-sm p-4">
        <dl class="row mb-0">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ data_get($course, 'id', '-') }}</dd>

            <dt class="col-sm-3">Número del curso</dt>
            <dd class="col-sm-9">{{ data_get($course, 'course_number', data_get($course, 'number', '-')) }}</dd>

            <dt class="col-sm-3">Día</dt>
            <dd class="col-sm-9">{{ data_get($course, 'day', '-') }}</dd>

            <dt class="col-sm-3">ID del área</dt>
            <dd class="col-sm-9">{{ data_get($course, 'area_id', '-') }}</dd>

            <dt class="col-sm-3">ID del centro de formación</dt>
            <dd class="col-sm-9">{{ data_get($course, 'training_center_id', '-') }}</dd>
        </dl>

        @if(data_get($course, 'id') !== null)
            <div class="mt-3">
                <a href="{{ route('courses.edit', data_get($course, 'id')) }}" class="btn btn-warning">Editar curso</a>
            </div>
        @endif
    </div>
@endsection
