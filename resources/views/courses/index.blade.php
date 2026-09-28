<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses</title>
    <style>
        :root { font-family: "Segoe UI", sans-serif; color: #172b2a; background: #f2f6f4; }
        * { box-sizing: border-box; }
        body { margin: 0; }
        header { background: #123b36; color: #fff; padding: 26px max(24px, calc((100vw - 1120px) / 2)); }
        header p { margin: 0 0 6px; color: #b9d8ca; font-size: 13px; }
        h1 { margin: 0; font-size: 28px; }
        nav { display: flex; flex-wrap: wrap; gap: 18px; margin-top: 14px; }
        nav a { color: #e0eee8; font-size: 14px; }
        main { max-width: 1120px; margin: 28px auto; padding: 0 20px; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 16px; }
        .toolbar p { margin: 0; color: #536461; font-size: 14px; }
        form { display: flex; gap: 8px; width: min(100%, 510px); }
        input { min-width: 0; flex: 1; padding: 10px 12px; border: 1px solid #bdcbc5; border-radius: 4px; background: #fff; font: inherit; }
        button, .clear { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 14px; border: 0; border-radius: 4px; background: #14745f; color: #fff; font: inherit; text-decoration: none; cursor: pointer; }
        .clear { background: #e1e9e5; color: #24443d; }
        .table-wrap { overflow-x: auto; border: 1px solid #d7e1dc; border-radius: 5px; background: #fff; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #e5ece8; white-space: nowrap; }
        th { background: #eaf1ed; color: #36514a; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        tbody tr:last-child td { border-bottom: 0; }
        .empty { padding: 30px; text-align: center; color: #536461; }
        @media (max-width: 620px) { .toolbar { align-items: stretch; flex-direction: column; } form { width: 100%; } header { padding: 22px 20px; } main { margin-top: 20px; } }
    </style>
</head>
<body>
    <header>
        <p>GESTIÓN</p>
        <h1>Courses</h1>
        <nav>
            <a href="{{ route('apprentices.index') }}">Aprendices</a>
            <a href="{{ route('computers.index') }}">Computers</a>
            <a href="{{ route('areas.index') }}">Áreas</a>
        </nav>
    </header>
    <main>
        <div class="toolbar">
            <p>{{ count($courses) }} registro(s)</p>
            <form action="{{ route('courses.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Buscar por número o día" aria-label="Buscar courses">
                <button type="submit">Buscar</button>
                @if(request('search'))
                    <a class="clear" href="{{ route('courses.index') }}">Limpiar</a>
                @endif
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número</th>
                        <th>Día</th>
                        <th>ID de área</th>
                        <th>ID del centro de formación</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>{{ data_get($course, 'id', '-') }}</td>
                            <td>{{ data_get($course, 'course_number', data_get($course, 'number', '-')) }}</td>
                            <td>{{ data_get($course, 'day', '-') }}</td>
                            <td>{{ data_get($course, 'area_id', '-') }}</td>
                            <td>{{ data_get($course, 'training_center_id', '-') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty" colspan="5">
                                {{ request('search') ? 'No se encontraron courses con esa búsqueda.' : 'No hay courses registrados.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
