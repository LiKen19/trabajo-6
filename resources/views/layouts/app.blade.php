<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Biblioteca')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body style="margin:0; padding:0; background:#f8f9fa;">

    <!-- Sidebar incluido -->
    @include('includes.sidebar')

    <!-- Contenido principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Ajuste general */
        html, body {
            height: 100%;
            overflow-x: hidden;
        }

        .main-content {
            min-height: 100vh;
            padding: 20px;
            transition: margin-left 0.3s ease;
            background-color: #f8f9fa;
        }

        /* En escritorio el contenido deja espacio al sidebar fijo */
        @media (min-width: 768px) {
            .main-content {
                margin-left: 250px; /* ancho del sidebar */
            }
        }

        /* En móvil el contenido se ajusta sin márgenes */
        @media (max-width: 767.98px) {
            .main-content {
                margin: 0;
                padding-top: 80px; /* espacio para el botón hamburguesa */
            }
        }
    </style>
</body>
</html>
