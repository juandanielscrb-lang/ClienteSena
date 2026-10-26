<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle del Aprendiz</title>
</head>
<body>
    <header>
        <h1>Detalles de {{ data_get($apprentice, 'name', '-') }}</h1>
    </header>
    <main>
        <p><a href="{{ route('apprentices.index') }}">Volver al listado</a></p>

        <ul>
            <li><strong>ID:</strong> {{ data_get($apprentice, 'id', '-') }}</li>
            <li><strong>Nombre:</strong> {{ data_get($apprentice, 'name', '-') }}</li>
            <li><strong>Correo:</strong> {{ data_get($apprentice, 'email', '-') }}</li>
            <li><strong>Celular:</strong> {{ data_get($apprentice, 'cell_number', 'No registrado') }}</li>
            <li><strong>Curso:</strong> {{ data_get($apprentice, 'course.course_number', 'Sin curso') }}</li>
            <li><strong>Computador:</strong> {{ data_get($apprentice, 'computer.number', 'Sin computador') }}</li>
        </ul>

        <a href="{{ route('apprentices.edit', data_get($apprentice, 'id')) }}">Editar este aprendiz</a>
    </main>
</body>
</html>