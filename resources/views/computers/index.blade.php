<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Computers</title>
</head>
<body>
    <header>
        <p>GESTION</p>
        <h1>Computers</h1>
        <a class="nav-link" href="{{ route('apprentices.index') }}">Ver aprendices</a>
    </header>
    <main>
        <div class="toolbar">
            <p>{{ count($computers) }} registro(s)</p>
            <form action="{{ route('computers.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Buscar por número o marca" aria-label="Buscar computers">
                <button type="submit">Buscar</button>
                @if(request('search'))
                    <a class="clear" href="{{ route('computers.index') }}">Limpiar</a>
                @endif
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número</th>
                        <th>Marca</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($computers as $computer)
                        <tr>
                            <td>{{ data_get($computer, 'id', '-') }}</td>
                            <td>{{ data_get($computer, 'number', '-') }}</td>
                            <td>{{ data_get($computer, 'brand', '-') }}</td>
                            <td>
                                @if(data_get($computer, 'urlFoto'))
                                    <img class="computer-photo" src="{{ data_get($computer, 'urlFoto') }}" alt="Computadora {{ data_get($computer, 'number', '') }}">
                                @else
                                    Sin foto
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty" colspan="4">
                                {{ request('search') ? 'No se encontraron computers con esa busqueda.' : 'No hay computers registrados.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
