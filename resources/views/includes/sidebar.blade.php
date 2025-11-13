<!-- Botón hamburguesa para móvil (solo visible en pantallas pequeñas) -->
<button class="btn d-md-none position-fixed top-0 start-0 m-3 z-3" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#mobileSidebar"
        style="background: #153052; color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
    <i class="bi bi-list fs-3"></i>
</button>

<!-- Sidebar Desktop (oculto en móvil) - AHORA CON POSICIÓN FIJA -->
<aside class="sidebar-desktop d-none d-md-flex flex-column flex-shrink-0 p-3 text-white position-fixed"
    style="width: 250px; height: 100vh; top: 0; left: 0;
        background: linear-gradient(180deg, #153052 76%, #B84A2F 100%);
        overflow-y: auto;">

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
                ['url' => '/user', 'icon' => '🧑‍💻', 'text' => 'Usuarios'],
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
                🔒 Cerrar sesión
            </button>
        </form>
    </div>
</aside>


<!-- Sidebar móvil offcanvas -->
<div class="offcanvas offcanvas-start" 
     tabindex="-1" 
     id="mobileSidebar" 
     aria-labelledby="mobileSidebarLabel"
     style="background: linear-gradient(180deg, #153052 76%, #B84A2F 100%); color: white;">
    
    <div class="offcanvas-header border-bottom border-white border-opacity-25">
        <div class="d-flex align-items-center">
            <img src="/img/logo.png" alt="Logo" style="width: 100px; height: auto;">
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    
    <div class="offcanvas-body p-0">
        <ul class="nav nav-pills flex-column p-3">
            @php
                $links = [
                    ['url' => '/dashboard', 'icon' => '🏠', 'text' => 'Dashboard'],
                    ['url' => '/cliente', 'icon' => '👥', 'text' => 'Clientes'],
                    ['url' => '/libro', 'icon' => '📚', 'text' => 'Libros'],
                    ['url' => '/prestamo', 'icon' => '📄', 'text' => 'Préstamos'],
                    ['url' => '/user', 'icon' => '🧑‍💻', 'text' => 'Usuarios'],
                ];
            @endphp

            @foreach ($links as $link)
                <li class="nav-item mb-2">
                    <a href="{{ url($link['url']) }}" 
                       class="nav-link text-white sidebar-link-mobile {{ Request::is(trim($link['url'], '/').'*') ? 'active-mobile' : '' }}">
                        <span class="fs-5 me-2">{!! $link['icon'] !!}</span>
                        <span class="fw-semibold">{{ $link['text'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        
        <hr class="border-white border-opacity-25 mx-3">
        
        <div class="p-3">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                    🔒 Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Estilos -->
<style>
    /* Sidebar Desktop - POSICIÓN FIJA */
    .sidebar-desktop {
        z-index: 1000;
    }

    .sidebar-desktop::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-desktop::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-desktop::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar-desktop::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

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

    /* Sidebar Mobile */
    .sidebar-link-mobile {
        border-radius: .375rem;
        font-weight: 500;
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
        border-left: 3px solid transparent;
    }

    .sidebar-link-mobile:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-left-color: #ffc107;
    }

    .sidebar-link-mobile.active-mobile {
        background-color: rgba(255, 255, 255, 0.15);
        border-left-color: #ffc107;
    }

    /* Ajuste para el contenido principal en móvil */
    @media (max-width: 767.98px) {
        .main-content {
            padding-top: 60px !important;
        }
    }

    /* Ajuste para el contenido principal en desktop */
    @media (min-width: 768px) {
        .main-content {
            margin-left: 250px !important;
        }
    }

    /* Z-index para el botón hamburguesa */
    .z-3 {
        z-index: 1030;
    }

    /* Animación del offcanvas */
    .offcanvas-start {
        width: 280px !important;
    }
</style>