@extends('layouts.app')

@section('content')
    <!-- Todo el contenido de tu tabla y buscador va aquí adentro -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Aprendices</h2>
        <a href="{{ route('apprentices.create') }}" class="btn btn-success">Crear Nuevo Aprendiz</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm p-3">
        <p>{{ count($apprentices) }} registro(s)</p>

        <form action="{{ route('apprentices.index') }}" method="GET" class="input-group mb-3">
            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar nombre, correo o celular">
            <button type="submit" class="btn btn-outline-success">Buscar</button>
            @if(request('search'))
                <a href="{{ route('apprentices.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Curso</th>
                        <th>Computador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apprentices as $apprentice)
                        <tr>
                            <td>{{ data_get($apprentice, 'id', '-') }}</td>
                            <td>{{ data_get($apprentice, 'name', '-') }}</td>
                            <td>{{ data_get($apprentice, 'email', '-') }}</td>
                            <td>{{ data_get($apprentice, 'cell_number', '-') }}</td>
                            <td>{{ data_get($apprentice, 'course.course_number', 'Sin curso') }}</td>
                            <td>{{ data_get($apprentice, 'computer.number', 'Sin computador') }}</td>
                            <td>
                                <a href="{{ route('apprentices.show', data_get($apprentice, 'id')) }}" class="btn btn-sm btn-info text-white">Ver</a>
                                <a href="{{ route('apprentices.edit', data_get($apprentice, 'id')) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('apprentices.destroy', data_get($apprentice, 'id')) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar registro?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                {{ request('search') ? 'No se encontraron resultados.' : 'No hay registros.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection