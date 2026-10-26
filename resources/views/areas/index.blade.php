@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Áreas</h2>
        <a href="{{ route('areas.create') }}" class="btn btn-success">Crear nueva área</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm p-3">
        <p>{{ count($areas) }} registro(s)</p>

        <form action="{{ route('areas.index') }}" method="GET" class="input-group mb-3">
            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por nombre o descripción" aria-label="Buscar áreas">
            <button type="submit" class="btn btn-outline-success">Buscar</button>
            @if(request('search'))
                <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($areas as $area)
                        @php($areaId = data_get($area, 'id'))
                        <tr>
                            <td>{{ $areaId ?? '-' }}</td>
                            <td>{{ data_get($area, 'name', data_get($area, 'area_name', data_get($area, 'area', '-'))) }}</td>
                            <td>{{ data_get($area, 'description', 'Sin descripción') }}</td>
                            <td>
                                @if($areaId !== null)
                                    <a href="{{ route('areas.show', $areaId) }}" class="btn btn-sm btn-info text-white">Ver</a>
                                    <a href="{{ route('areas.edit', $areaId) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('areas.destroy', $areaId) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta área?')">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                {{ request('search') ? 'No se encontraron áreas con esa búsqueda.' : 'No hay áreas registradas.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
