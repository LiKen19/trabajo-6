<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { width: 250px; min-height: 100vh; background-color: #153052; }
        .sidebar a { color: white; border-radius: .375rem; }
        .sidebar a.active, .sidebar a:hover { background-color: #0b5ed7; color: white; }
        main { flex-grow: 1; padding: 1rem; }
    </style>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

</head>
<body>
    <!-- Botón para abrir/cerrar menú en móvil -->
<nav class="navbar bg-primary text-white d-md-none">
  <div class="container-fluid">
    <button class="btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
      ☰ Menú
    </button>
  </div>
</nav>

<div class="d-flex flex-column flex-md-row">

    <!-- Sidebar -->
    <div class="collapse d-md-block sidebar" id="sidebarMenu">
        @include('includes.sidebar')
    </div>

    <!-- Contenido principal -->
    <main class="flex-grow-1 p-3 p-md-4">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
