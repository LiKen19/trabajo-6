<!-- resources/views/includes/sidebar.blade.php -->
<aside class="d-flex flex-column flex-shrink-0 p-3 text-white"
    style="width: 250px; min-height: 100vh;
        background: linear-gradient(180deg, #153052 76%, #B84A2F 100%);">

    <!-- Logo centrado -->
    <a href="#" class="d-flex justify-content-center align-items-center mb-4 text-decoration-none sidebar-logo">
        <img src="/img/logo.png" alt="Logo" class="img-fluid" style="width:140px; height:auto;">
    </a>

    <!-- Navegación -->
    <ul class="nav nav-pills flex-column mb-auto">
        @php
            $links = [
                ['url' => 'dashboard', 'icon' => '🏠', 'text' => 'Dashboard'],
                ['url' => '/cliente', 'icon' => '👥', 'text' => 'Clientes'],
                ['url' => '/libro', 'icon' => '📚', 'text' => 'Libros'],
                ['url' => '/prestamo', 'icon' => '📄', 'text' => 'Préstamos'],
                ['url' => '#', 'icon' => '🧑‍💻', 'text' => 'Usuarios'],
            ];
        @endphp

        @foreach ($links as $link)
            <li class="nav-item mb-2">
                <a href="{{ $link['url'] }}"
                    class="nav-link text-white sidebar-link {{ Request::is(trim($link['url'], '/').'*') ? 'active' : '' }}">
                    {!! $link['icon'] !!} {{ $link['text'] }}
                    <span class="active-bar"></span>
                </a>
            </li>
        @endforeach
    </ul>

    <hr class="my-3">

    <!-- Logout -->
    <div class="mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>


<!-- Sidebar móvil offcanvas -->
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">Menú</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="nav nav-pills flex-column mb-auto p-3">
            @foreach ($links as $link)
                <li class="nav-item mb-2">
                    <a href="{{ $link['url'] }}" class="nav-link">{{ $link['icon'] }} {{ $link['text'] }}</a>
                </li>
            @endforeach
        </ul>
        <hr>
        <div class="p-3">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                    🔒 Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Estilos extra -->
<style>
    /* Sidebar links */
    .sidebar-link {
        border-radius: .375rem;
        font-weight: 600;
        font-size: 1.6rem;
        position: relative;
        padding-left: 1rem;
        transition: background 0.3s;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar-link .active-bar {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 0;
        background-color: #ffc107;
        border-radius: 0 .25rem .25rem 0;
        transition: width 0.3s;
    }

    .sidebar-link:hover .active-bar,
    .sidebar-link.active .active-bar {
        width: 4px;
    }
</style>
