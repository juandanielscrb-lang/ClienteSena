<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminSena</title>
    
    <!-- Aquí incluimos las dependencias del Head (CSS, Bootstrap, etc.) -->
    @include('includes.dependencias')
</head>
<body>
    <!-- Barra de navegación global -->
    @include('includes.navbar')

    <main class="container my-4">
        <!-- Aquí se inyectará el contenido de cada vista (index, create, etc.) -->
        @yield('content')
    </main>

    <!-- Pie de página -->
    @include('includes.footer')

    <!-- Aquí incluimos los scripts del Body (JS) -->
    @include('includes.dependenciasbody')
</body>
</html>