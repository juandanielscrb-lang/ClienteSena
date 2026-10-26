@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Cursos</h2>
        <a href="{{ route('courses.create') }}" class="btn btn-success">Crear nuevo curso</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm p-3">
        <p>{{ count($courses) }} registro(s)</p>

        <form action="{{ route('courses.index') }}" method="GET" class="input-group mb-3">
            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por número o día" aria-label="Buscar cursos">
            <button type="submit" class="btn btn-outline-success">Buscar</button>
            @if(request('search'))
                <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número</th>
                        <th>Día</th>
                        <th>ID de área</th>
                        <th>ID del centro de formación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        @php($courseId = data_get($course, 'id'))
                        <tr>
                            <td>{{ $courseId ?? '-' }}</td>
                            <td>{{ data_get($course, 'course_number', data_get($course, 'number', '-')) }}</td>
                            <td>{{ data_get($course, 'day', '-') }}</td>
                            <td>{{ data_get($course, 'area_id', '-') }}</td>
                            <td>{{ data_get($course, 'training_center_id', '-') }}</td>
                            <td>
                                @if($courseId !== null)
                                    <a href="{{ route('courses.show', $courseId) }}" class="btn btn-sm btn-info text-white">Ver</a>
                                    <a href="{{ route('courses.edit', $courseId) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('courses.destroy', $courseId) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este curso?')">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                {{ request('search') ? 'No se encontraron cursos con esa búsqueda.' : 'No hay cursos registrados.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
