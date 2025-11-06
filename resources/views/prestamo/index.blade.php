@extends('layouts.app')

@section('title', 'Préstamos')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header con botón -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Préstamos</h2>
        <button class="btn btn-secondary px-4" data-bs-toggle="modal" data-bs-target="#createModal" style="background: #A674C9">
            <i class="bi bi-plus-circle me-2"></i>Agregar préstamo
        </button>
    </div>

    <!-- Tarjeta de búsqueda -->
    <div class="card shadow-sm mb-4 border-0" style="background: linear-gradient(135deg, #f8e8e8 0%, #f3d4d4 100%); border-radius: 20px;">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap p-3">
            <div class="flex-grow-1 pe-3" style="max-width: 600px;">
                <h4 class="fw-bold mb-3">Buscar Préstamo</h4>
                <input type="text" id="searchInput" class="form-control border-0 shadow-sm" 
                    placeholder="Buscar por cliente, libro o estado..." 
                    style="background-color: #e8c5c5; border-radius: 15px; padding: 12px 20px; font-size: 15px;">
            </div>
            <div class="text-center">
                <img src="/img/Prestamos.png" alt="Préstamos" style="width: 120px; height: auto;">
            </div>
        </div>
    </div>

    <!-- Tabla de préstamos -->
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="prestamosTable" style="background-color: #faf5f5;">
                <thead style="background-color: #f0e5e5;">
                    <tr>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">ID</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Cliente</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Libro</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Estado</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos as $prestamo)
                    <tr style="border-bottom: 1px solid #f0e5e5;">
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $prestamo->id }}</td>
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $prestamo->cliente->nombre ?? '' }} {{ $prestamo->cliente->apellido ?? '' }}</td>
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $prestamo->libro->titulo ?? '' }}</td>
                        <td class="text-center py-3">
                            <span class="badge {{ $prestamo->estado === 'Prestado' ? 'bg-warning text-dark' : 'bg-success' }} px-3 py-2" style="border-radius: 10px;">
                                {{ $prestamo->estado }}
                            </span>
                        </td>
                        <td class="text-center py-3">
                            <div class="d-flex gap-2 justify-content-center">
                                <!-- Botón Mostrar (Amarillo) -->
                                <button class="btn btn-sm showBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #ffd700; border: none;"
                                    data-cliente="{{ $prestamo->cliente->nombre ?? '' }} {{ $prestamo->cliente->apellido ?? '' }}"
                                    data-libro="{{ $prestamo->libro->titulo ?? '' }}"
                                    data-fecha_prestamo="{{ $prestamo->fecha_prestamo }}"
                                    data-fecha_devolucion="{{ $prestamo->fecha_devolucion ?? '—' }}"
                                    data-estado="{{ $prestamo->estado }}"
                                    title="Ver detalles">
                                    <i class="bi bi-eye" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Editar (Verde) -->
                                <button class="btn btn-sm editBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #4ade80; border: none;"
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $prestamo->id }}"
                                    data-cliente_id="{{ $prestamo->cliente_id }}"
                                    data-libro_id="{{ $prestamo->libro_id }}"
                                    data-fecha_prestamo="{{ $prestamo->fecha_prestamo }}"
                                    data-fecha_devolucion="{{ $prestamo->fecha_devolucion }}"
                                    data-estado="{{ $prestamo->estado }}"
                                    title="Editar">
                                    <i class="bi bi-pencil" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Eliminar (Rojo) -->
                                <form action="{{ route('prestamo.destroy', $prestamo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center" 
                                        style="width: 36px; height: 36px; background-color: #ef4444; border: none;"
                                        onclick="return confirm('¿Estás seguro de eliminar este préstamo?')"
                                        title="Eliminar">
                                        <i class="bi bi-trash" style="color: #fff; font-size: 16px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color: #7F7A7A;">No hay préstamos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Mostrar Préstamo -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detalles del Préstamo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <strong>Cliente:</strong>
                    <p class="mb-0" id="show_cliente"></p>
                </div>
                <div class="mb-3">
                    <strong>Libro:</strong>
                    <p class="mb-0" id="show_libro"></p>
                </div>
                <div class="mb-3">
                    <strong>Fecha de préstamo:</strong>
                    <p class="mb-0" id="show_fecha_prestamo"></p>
                </div>
                <div class="mb-3">
                    <strong>Fecha de devolución:</strong>
                    <p class="mb-0" id="show_fecha_devolucion"></p>
                </div>
                <div class="mb-3">
                    <strong>Estado:</strong>
                    <p class="mb-0" id="show_estado"></p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Préstamo -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Editar Préstamo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cliente</label>
                        <select name="cliente_id" id="edit_cliente" class="form-control" required style="border-radius: 10px;">
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Libro</label>
                        <select name="libro_id" id="edit_libro" class="form-control" required style="border-radius: 10px;">
                            @foreach($libros as $libro)
                                <option value="{{ $libro->id }}">{{ $libro->titulo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fecha de préstamo</label>
                        <input type="date" name="fecha_prestamo" id="edit_fecha_prestamo" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fecha de devolución</label>
                        <input type="date" name="fecha_devolucion" id="edit_fecha_devolucion" class="form-control" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estado</label>
                        <select name="estado" id="edit_estado" class="form-control" required style="border-radius: 10px;">
                            <option value="Prestado">Prestado</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Agregar Préstamo -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form action="{{ route('prestamo.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Agregar Préstamo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cliente</label>
                        <select name="cliente_id" class="form-control" required style="border-radius: 10px;">
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Libro</label>
                        <select name="libro_id" class="form-control" required style="border-radius: 10px;">
                            <option value="">Seleccione un libro</option>
                            @foreach($libros as $libro)
                                @if($libro->estado === 'Disponible')
                                    <option value="{{ $libro->id }}">{{ $libro->titulo }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fecha de préstamo</label>
                        <input type="date" name="fecha_prestamo" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fecha de devolución</label>
                        <input type="date" name="fecha_devolucion" class="form-control" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estado</label>
                        <select name="estado" class="form-control" required style="border-radius: 10px;">
                            <option value="Prestado">Prestado</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS y Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar Modal
    const showModal = new bootstrap.Modal(document.getElementById('showModal'));
    document.querySelectorAll('.showBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('show_cliente').textContent = this.dataset.cliente;
            document.getElementById('show_libro').textContent = this.dataset.libro;
            document.getElementById('show_fecha_prestamo').textContent = this.dataset.fecha_prestamo;
            document.getElementById('show_fecha_devolucion').textContent = this.dataset.fecha_devolucion;
            document.getElementById('show_estado').textContent = this.dataset.estado;
            showModal.show();
        });
    });

    // Editar Modal
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
            // Verificar si es la fila de "No hay préstamos"
            if (row.cells.length < 5) {
                return;
            }

            const cliente = row.cells[1].textContent.toLowerCase();
            const libro = row.cells[2].textContent.toLowerCase();
            const estado = row.cells[3].textContent.toLowerCase();

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