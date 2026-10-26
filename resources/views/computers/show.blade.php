@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalle del computador</h2>
        <a href="{{ route('computers.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <div class="card shadow-sm p-4">
        <dl class="row mb-0">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ data_get($computer, 'id', '-') }}</dd>

            <dt class="col-sm-3">Número</dt>
            <dd class="col-sm-9">{{ data_get($computer, 'number', '-') }}</dd>

            <dt class="col-sm-3">Marca</dt>
            <dd class="col-sm-9">{{ data_get($computer, 'brand', '-') }}</dd>

            <dt class="col-sm-3">Foto</dt>
            <dd class="col-sm-9">
                @if(data_get($computer, 'urlFoto'))
                    <img src="http://api.adminsena.test/storage/images/{{ data_get($computer, 'urlFoto') }}" alt="Computadora {{ data_get($computer, 'number', '') }}" style="max-width: 240px; max-height: 180px;" class="img-thumbnail">
                @else
                    Sin foto
                @endif
            </dd>
        </dl>

        @if(data_get($computer, 'id') !== null)
            <div class="mt-3">
                <a href="{{ route('computers.edit', data_get($computer, 'id')) }}" class="btn btn-warning">Editar computador</a>
            </div>
        @endif
    </div>
@endsection
