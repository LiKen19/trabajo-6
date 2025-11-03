@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Estadísticas -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center p-4 shadow-sm">
                <div class="display-4 mb-2">👥</div>
                <h5 class="card-title">Total de Clientes</h5>
                <p class="fs-2 fw-bold">{{ $total_clientes }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white text-center p-4 shadow-sm">
                <div class="display-4 mb-2">📚</div>
                <h5 class="card-title">Libros Disponibles</h5>
                <p class="fs-2 fw-bold">{{ $total_libros_disponibles }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-danger text-white text-center p-4 shadow-sm">
                <div class="display-4 mb-2">📝</div>
                <h5 class="card-title">Préstamos Activos</h5>
                <p class="fs-2 fw-bold">{{ $total_prestamos_activos }}</p>
            </div>
        </div>
    </div>

    <!-- Subtítulo Gestión Rápida -->
    <h4 class="mb-4">Gestión Rápida</h4>

    <!-- Botones grandes de gestión rápida -->
    <div class="d-flex flex-wrap gap-3 mb-5">
        <button class="btn btn-primary btn-lg px-5 py-3" data-bs-toggle="modal" data-bs-target="#createClienteModal">
            Agregar Cliente
        </button>
        <button class="btn btn-success btn-lg px-5 py-3" data-bs-toggle="modal" data-bs-target="#createLibroModal">
            Agregar Libro
        </button>
        <button class="btn btn-warning btn-lg text-white px-5 py-3" data-bs-toggle="modal" data-bs-target="#createPrestamoModal">
            Registrar Préstamo
        </button>
    </div>
</div>

<!-- Modales de creación rápida -->
@include('partials.create_cliente_modal')
@include('partials.create_libro_modal')
@include('partials.create_prestamo_modal')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
