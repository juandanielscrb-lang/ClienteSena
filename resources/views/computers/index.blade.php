@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Computadores</h2>
        <a href="{{ route('computers.create') }}" class="btn btn-success">Registrar computador</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!empty($apiError))
        <div class="alert alert-danger">{{ $apiError }}</div>
    @endif

    <div class="card shadow-sm p-3">
        <p>{{ count($computers) }} registro(s)</p>

        <form action="{{ route('computers.index') }}" method="GET" class="input-group mb-3">
            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por número o marca" aria-label="Buscar computadores">
            <button type="submit" class="btn btn-outline-success">Buscar</button>
            @if(request('search'))
                <a href="{{ route('computers.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número</th>
                        <th>Marca</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($computers as $computer)
                        @php($computerId = data_get($computer, 'id'))
                        <tr>
                            <td>{{ $computerId ?? '-' }}</td>
                            <td>{{ data_get($computer, 'number', '-') }}</td>
                            <td>{{ data_get($computer, 'brand', '-') }}</td>
                            <td>
                                @if(data_get($computer, 'urlFoto'))
                                    <img src="{{ data_get($computer, 'urlFoto') }}" alt="Computadora {{ data_get($computer, 'number', '') }}" style="max-width: 100px; max-height: 70px;">
                                @else
                                    Sin foto
                                @endif
                            </td>
                            <td>
                                @if($computerId !== null)
                                    <a href="{{ route('computers.show', $computerId) }}" class="btn btn-sm btn-info text-white">Ver</a>
                                    <a href="{{ route('computers.edit', $computerId) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('computers.destroy', $computerId) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este computador?')">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                {{ request('search') ? 'No se encontraron computadores con esa búsqueda.' : 'No hay computadores registrados.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
