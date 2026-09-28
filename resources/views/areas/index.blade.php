<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Áreas</title>
</head>
<body>
    <header>
        <p>GESTIÓN</p>
        <h1>Áreas</h1>
        <nav>
            <a href="{{ route('apprentices.index') }}">Aprendices</a>
            <a href="{{ route('computers.index') }}">Computers</a>
        </nav>
    </header>
    <main>
        <div class="toolbar">
            <p>{{ count($areas) }} registro(s)</p>
            <form action="{{ route('areas.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o descripción" aria-label="Buscar áreas">
                <button type="submit">Buscar</button>
                @if(request('search'))
                    <a class="clear" href="{{ route('areas.index') }}">Limpiar</a>
                @endif
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($areas as $area)
                        <tr>
                            <td>{{ data_get($area, 'id', '-') }}</td>
                            <td>{{ data_get($area, 'name', data_get($area, 'area_name', data_get($area, 'area', '-'))) }}</td>
                            <td>{{ data_get($area, 'description', 'Sin descripción') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty" colspan="3">
                                {{ request('search') ? 'No se encontraron áreas con esa búsqueda.' : 'No hay áreas registradas.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
