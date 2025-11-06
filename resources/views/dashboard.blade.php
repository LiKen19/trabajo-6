@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header con saludo -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">¡Bienvenido, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-muted mb-0">Aquí tienes un resumen de tu biblioteca</p>
        </div>
        <div class="text-end">
            <small class="text-muted">{{ now()->format('d/m/Y') }}</small>
        </div>
    </div>

    <!-- Tarjetas de estadísticas mejoradas -->
    <div class="row g-4 mb-5">
        <!-- Total Clientes -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Clientes</h6>
                            <h2 class="fw-bold mb-0">{{ $total_clientes }}</h2>
                        </div>
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <small class="text-white-50">📊 Gestión de usuarios</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Libros Disponibles -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-white-50 mb-2">Libros Disponibles</h6>
                            <h2 class="fw-bold mb-0">{{ $total_libros_disponibles }}</h2>
                        </div>
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle">
                            <i class="bi bi-book-fill fs-3"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <small class="text-white-50">📚 Listos para préstamo</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Préstamos Activos -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-white-50 mb-2">Préstamos Activos</h6>
                            <h2 class="fw-bold mb-0">{{ $total_prestamos_activos }}</h2>
                        </div>
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle">
                            <i class="bi bi-arrow-left-right fs-3"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <small class="text-white-50">📝 En circulación</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Libros -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Libros</h6>
                            <h2 class="fw-bold mb-0">{{ $total_libros ?? 0 }}</h2>
                        </div>
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle">
                            <i class="bi bi-collection-fill fs-3"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <small class="text-white-50">📖 En inventario</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de acciones rápidas -->
    <div class="row g-4 mb-4">
        <!-- Gestión Rápida -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-lightning-charge-fill text-warning"></i> Acciones Rápidas
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <button class="btn w-100 py-3 border-0 shadow-sm" 
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px;"
                                data-bs-toggle="modal" data-bs-target="#createClienteModal">
                                <i class="bi bi-person-plus-fill fs-2 mb-2 d-block"></i>
                                <span class="fw-semibold">Agregar Cliente</span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn w-100 py-3 border-0 shadow-sm" 
                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px;"
                                data-bs-toggle="modal" data-bs-target="#createLibroModal">
                                <i class="bi bi-book-half fs-2 mb-2 d-block"></i>
                                <span class="fw-semibold">Agregar Libro</span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn w-100 py-3 border-0 shadow-sm" 
                                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px;"
                                data-bs-toggle="modal" data-bs-target="#createPrestamoModal">
                                <i class="bi bi-clipboard-check-fill fs-2 mb-2 d-block"></i>
                                <span class="fw-semibold">Nuevo Préstamo</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas adicionales -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: linear-gradient(135deg, #f8e8e8 0%, #f3d4d4 100%);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-graph-up text-success"></i> Estado General
                    </h5>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="fw-semibold">Tasa de préstamo</small>
                            <small class="text-muted">
                                {{ $total_libros > 0 ? round(($total_prestamos_activos / $total_libros) * 100, 1) : 0 }}%
                            </small>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar" role="progressbar" 
                                style="width: {{ $total_libros > 0 ? ($total_prestamos_activos / $total_libros) * 100 : 0 }}%; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="fw-semibold">Disponibilidad</small>
                            <small class="text-muted">
                                {{ $total_libros > 0 ? round(($total_libros_disponibles / $total_libros) * 100, 1) : 0 }}%
                            </small>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar" role="progressbar" 
                                style="width: {{ $total_libros > 0 ? ($total_libros_disponibles / $total_libros) * 100 : 0 }}%; background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);">
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="text-center">
                        <small class="text-muted d-block mb-2">Sistema actualizado</small>
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <small class="text-success ms-1">Todo operativo</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos directos a módulos -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-grid-3x3-gap-fill text-primary"></i> Módulos del Sistema
            </h5>
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <a href="/cliente" class="text-decoration-none">
                        <div class="p-4 text-center rounded-3 border border-2 hover-lift" style="transition: all 0.3s;">
                            <i class="bi bi-people-fill fs-1 mb-2" style="color: #667eea;"></i>
                            <h6 class="fw-semibold mb-0 text-dark">Clientes</h6>
                            <small class="text-muted">Gestionar usuarios</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="/libro" class="text-decoration-none">
                        <div class="p-4 text-center rounded-3 border border-2 hover-lift" style="transition: all 0.3s;">
                            <i class="bi bi-book-fill fs-1 mb-2" style="color: #f5576c;"></i>
                            <h6 class="fw-semibold mb-0 text-dark">Libros</h6>
                            <small class="text-muted">Inventario completo</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="/prestamo" class="text-decoration-none">
                        <div class="p-4 text-center rounded-3 border border-2 hover-lift" style="transition: all 0.3s;">
                            <i class="bi bi-arrow-left-right fs-1 mb-2" style="color: #00f2fe;"></i>
                            <h6 class="fw-semibold mb-0 text-dark">Préstamos</h6>
                            <small class="text-muted">Control de préstamos</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="/user" class="text-decoration-none">
                        <div class="p-4 text-center rounded-3 border border-2 hover-lift" style="transition: all 0.3s;">
                            <i class="bi bi-person-circle fs-1 mb-2" style="color: #fee140;"></i>
                            <h6 class="fw-semibold mb-0 text-dark">Usuarios</h6>
                            <small class="text-muted">Administrar accesos</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de creación rápida -->
@include('partials.create_cliente_modal')
@include('partials.create_libro_modal')
@include('partials.create_prestamo_modal')

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
/* Efectos hover para las tarjetas de módulos */
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    border-color: #A674C9 !important;
}

/* Animación suave para las tarjetas de estadísticas */
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

/* Estilos para progress bars */
.progress {
    background-color: rgba(0,0,0,0.05);
}

/* Responsive */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem !important;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection