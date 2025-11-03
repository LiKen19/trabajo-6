@extends('layouts.app')

@section('title', 'Préstamos')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">Gestión de Préstamos</h2>

    <!-- Filtro y botón Agregar -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <!-- Filtro a la izquierda -->
        <input type="text" id="searchInput" class="form-control me-2 mb-2 mb-md-0" style="max-width: 300px;" placeholder="Buscar préstamo...">

        <!-- Botón Agregar a la derecha -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Agregar libro
        </button>
    </div>

    <!-- Tabla de préstamos -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" id="prestamosTable">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Libro</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->cliente->nombre ?? '' }} {{ $prestamo->cliente->apellido ?? '' }}</td>
                    <td>{{ $prestamo->libro->titulo ?? '' }}</td>
                    <td>
                        <span class="badge {{ $prestamo->estado === 'Prestado' ? 'bg-warning text-dark' : 'bg-success' }}">
                            {{ $prestamo->estado }}
                        </span>
                    </td>
                    <td class="d-flex gap-1 flex-wrap">
                        <!-- Botón Mostrar -->
                        <button class="btn btn-info btn-sm showBtn"
                            data-cliente="{{ $prestamo->cliente->nombre ?? '' }} {{ $prestamo->cliente->apellido ?? '' }}"
                            data-libro="{{ $prestamo->libro->titulo ?? '' }}"
                            data-fecha_prestamo="{{ $prestamo->fecha_prestamo }}"
                            data-fecha_devolucion="{{ $prestamo->fecha_devolucion ?? '—' }}"
                            data-estado="{{ $prestamo->estado }}">
                            Mostrar
                        </button>

                        <!-- Botón Editar -->
                        <button class="btn btn-warning btn-sm editBtn"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="{{ $prestamo->id }}"
                            data-cliente_id="{{ $prestamo->cliente_id }}"
                            data-libro_id="{{ $prestamo->libro_id }}"
                            data-fecha_prestamo="{{ $prestamo->fecha_prestamo }}"
                            data-fecha_devolucion="{{ $prestamo->fecha_devolucion }}"
                            data-estado="{{ $prestamo->estado }}">
                            Editar
                        </button>

                        <!-- Botón Eliminar -->
                        <form action="{{ route('prestamo.destroy', $prestamo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Seguro que deseas eliminar este préstamo?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No hay préstamos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Mostrar -->
<div class="modal fade" id="showModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del préstamo</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Cliente:</strong> <span id="show_cliente"></span></p>
                <p><strong>Libro:</strong> <span id="show_libro"></span></p>
                <p><strong>Fecha de préstamo:</strong> <span id="show_fecha_prestamo"></span></p>
                <p><strong>Fecha de devolución:</strong> <span id="show_fecha_devolucion"></span></p>
                <p><strong>Estado:</strong> <span id="show_estado"></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('prestamo.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Préstamo</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Cliente</label>
                        <select name="cliente_id" class="form-select" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Libro</label>
                        <select name="libro_id" class="form-select" required>
                            <option value="">Seleccione un libro</option>
                            @foreach($libros as $libro)
                                @if($libro->estado === 'Disponible')
                                    <option value="{{ $libro->id }}">{{ $libro->titulo }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Fecha de préstamo</label>
                        <input type="date" name="fecha_prestamo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Fecha de devolución</label>
                        <input type="date" name="fecha_devolucion" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="Prestado">Prestado</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Préstamo</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Cliente</label>
                        <select name="cliente_id" id="edit_cliente" class="form-select" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Libro</label>
                        <select name="libro_id" id="edit_libro" class="form-select" required>
                            @foreach($libros as $libro)
                                <option value="{{ $libro->id }}">{{ $libro->titulo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Fecha de préstamo</label>
                        <input type="date" id="edit_fecha_prestamo" name="fecha_prestamo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Fecha de devolución</label>
                        <input type="date" id="edit_fecha_devolucion" name="fecha_devolucion" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Estado</label>
                        <select name="estado" id="edit_estado" class="form-select" required>
                            <option value="Prestado">Prestado</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Mostrar detalles
    const showModal = new bootstrap.Modal(document.getElementById('showModal'));
    document.querySelectorAll('.showBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('show_cliente').textContent = btn.dataset.cliente;
            document.getElementById('show_libro').textContent = btn.dataset.libro;
            document.getElementById('show_fecha_prestamo').textContent = btn.dataset.fecha_prestamo;
            document.getElementById('show_fecha_devolucion').textContent = btn.dataset.fecha_devolucion;
            document.getElementById('show_estado').textContent = btn.dataset.estado;
            showModal.show();
        });
    });

    // Editar modal
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('edit_cliente').value = button.dataset.cliente_id;
        document.getElementById('edit_libro').value = button.dataset.libro_id;
        document.getElementById('edit_fecha_prestamo').value = button.dataset.fecha_prestamo;
        document.getElementById('edit_fecha_devolucion').value = button.dataset.fecha_devolucion;
        document.getElementById('edit_estado').value = button.dataset.estado;

        document.getElementById('editForm').action = `/prestamo/${button.dataset.id}`;
    });

    // Filtro dinámico
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#prestamosTable tbody tr');

        rows.forEach(row => {
            const cliente = row.cells[0].textContent.toLowerCase();
            const libro = row.cells[1].textContent.toLowerCase();
            const estado = row.cells[2].textContent.toLowerCase();

            if (cliente.includes(filter) || libro.includes(filter) || estado.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
