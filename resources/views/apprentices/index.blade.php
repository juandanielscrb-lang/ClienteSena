<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aprendices</title>
</head>
<body>
    <header>
        <p>GESTION</p>
        <h1>Aprendices</h1>
    </header>
    <main>
        <div class="toolbar">
            <p>{{ count($apprentices) }} registro(s)</p>
            <form action="{{ route('apprentices.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Buscar nombre, correo o celular" aria-label="Buscar aprendices">
                <button type="submit">Buscar</button>
                @if(request('search'))
                    <a class="clear" href="{{ route('apprentices.index') }}">Limpiar</a>
                @endif
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Curso</th>
                        <th>Computador</th>
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
                        </tr>
                    @empty
                        <tr>
                            <td class="empty" colspan="6">
                                {{ request('search') ? 'No se encontraron aprendices con esa busqueda.' : 'No hay aprendices registrados.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>