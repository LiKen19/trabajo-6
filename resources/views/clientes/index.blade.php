@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Gestión de Clientes</h2>

    <!-- Filtro y Botón Agregar en la misma línea -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <!-- Filtro a la izquierda -->
        <input type="text" id="searchInput" class="form-control me-2 mb-2 mb-md-0" style="max-width: 300px;" placeholder="Buscar libro...">

        <!-- Botón Agregar a la derecha -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Agregar libro
        </button>
    </div>

    <!-- Tabla de clientes -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle" id="clientesTable">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                    <td>{{ $cliente->dni }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td class="d-flex gap-1 flex-wrap">
                        <!-- Botón Mostrar -->
                        <button class="btn btn-info btn-sm showBtn"
                            data-nombre="{{ $cliente->nombre }}"
                            data-apellido="{{ $cliente->apellido }}"
                            data-dni="{{ $cliente->dni }}"
                            data-telefono="{{ $cliente->telefono }}"
                            data-direccion="{{ $cliente->direccion }}"
                            data-correo="{{ $cliente->correo }}">
                            Mostrar
                        </button>

                        <!-- Botón Editar -->
                        <button class="btn btn-warning btn-sm editBtn"
                            data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="{{ $cliente->id }}"
                            data-nombre="{{ $cliente->nombre }}"
                            data-apellido="{{ $cliente->apellido }}"
                            data-dni="{{ $cliente->dni }}"
                            data-telefono="{{ $cliente->telefono }}"
                            data-direccion="{{ $cliente->direccion }}"
                            data-correo="{{ $cliente->correo }}">
                            Editar
                        </button>

                        <!-- Botón Eliminar -->
                        <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Mostrar Cliente -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> <span id="show_nombre"></span></p>
                <p><strong>Apellido:</strong> <span id="show_apellido"></span></p>
                <p><strong>DNI:</strong> <span id="show_dni"></span></p>
                <p><strong>Teléfono:</strong> <span id="show_telefono"></span></p>
                <p><strong>Dirección:</strong> <span id="show_direccion"></span></p>
                <p><strong>Correo:</strong> <span id="show_correo"></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Cliente -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Apellido:</label>
                        <input type="text" name="apellido" id="edit-apellido" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>DNI:</label>
                        <input type="text" name="dni" id="edit-dni" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" id="edit-telefono" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Dirección:</label>
                        <input type="text" name="direccion" id="edit-direccion" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Correo:</label>
                        <input type="email" name="correo" id="edit-correo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Agregar Cliente -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cliente.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Apellido</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>DNI</label>
                        <input type="text" name="dni" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Correo</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS y Scripts para modales y filtro -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar Modal
    const showModal = new bootstrap.Modal(document.getElementById('showModal'));
    document.querySelectorAll('.showBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('show_nombre').textContent = this.dataset.nombre;
            document.getElementById('show_apellido').textContent = this.dataset.apellido;
            document.getElementById('show_dni').textContent = this.dataset.dni;
            document.getElementById('show_telefono').textContent = this.dataset.telefono;
            document.getElementById('show_direccion').textContent = this.dataset.direccion;
            document.getElementById('show_correo').textContent = this.dataset.correo;
            showModal.show();
        });
    });

    // Editar Modal
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('edit-nombre').value = button.dataset.nombre;
        document.getElementById('edit-apellido').value = button.dataset.apellido;
        document.getElementById('edit-dni').value = button.dataset.dni;
        document.getElementById('edit-telefono').value = button.dataset.telefono;
        document.getElementById('edit-direccion').value = button.dataset.direccion;
        document.getElementById('edit-correo').value = button.dataset.correo;

        document.getElementById('editForm').action = `/cliente/${button.dataset.id}`;
    });

    // Filtro dinámico
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#clientesTable tbody tr');

        rows.forEach(row => {
            const nombre = row.cells[0].textContent.toLowerCase();
            const dni = row.cells[1].textContent.toLowerCase();
            const telefono = row.cells[2].textContent.toLowerCase();
            const direccion = row.cells[3].textContent.toLowerCase();

            if (nombre.includes(filter) || dni.includes(filter) || telefono.includes(filter) || direccion.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
