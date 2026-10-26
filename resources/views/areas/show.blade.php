@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalle del área</h2>
        <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <div class="card shadow-sm p-4">
        <dl class="row mb-0">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ data_get($area, 'id', '-') }}</dd>

            <dt class="col-sm-3">Nombre</dt>
            <dd class="col-sm-9">{{ data_get($area, 'name', data_get($area, 'area_name', data_get($area, 'area', '-'))) }}</dd>

            <dt class="col-sm-3">Descripción</dt>
            <dd class="col-sm-9">{{ data_get($area, 'description', 'Sin descripción') }}</dd>
        </dl>

        @if(data_get($area, 'id') !== null)
            <div class="mt-3">
                <a href="{{ route('areas.edit', data_get($area, 'id')) }}" class="btn btn-warning">Editar área</a>
            </div>
        @endif
    </div>
@endsection
