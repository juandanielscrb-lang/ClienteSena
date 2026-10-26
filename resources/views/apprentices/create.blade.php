<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Aprendiz</title>
</head>
<body>
    <header>
        <h1>Registrar Nuevo Aprendiz</h1>
    </header>
    <main>
        <p><a href="{{ route('apprentices.index') }}">Volver al listado</a></p>

        <!-- Muestra errores de validación si los hay -->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('apprentices.store') }}" method="POST">
            @csrf
            <div>
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div>
                <label for="email">Correo:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>
            <div>
                <label for="cell_number">Celular:</label>
                <input type="text" name="cell_number" id="cell_number" value="{{ old('cell_number') }}">
            </div>
            <!-- Si manejas relaciones con curso y computador, aquí irían selects -->
            
            <button type="submit">Guardar Aprendiz</button>
        </form>
    </main>
</body>
</html>