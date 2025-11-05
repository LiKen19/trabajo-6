@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header con botón -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Clientes</h2>
        <button class="btn btn-secondary px-4" data-bs-toggle="modal" data-bs-target="#createModal" style="background: #A674C9">
            <i class="bi bi-plus-circle me-2"></i>Agregar cliente
        </button>
    </div>


    <!-- Tarjeta de búsqueda -->
    <div class="card shadow-sm mb-4 border-0" style="background: linear-gradient(135deg, #f8e8e8 0%, #f3d4d4 100%); border-radius: 20px;">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap p-3">
            <div class="flex-grow-1 pe-3" style="max-width: 600px;">
                <h4 class="fw-bold mb-3">Buscar Cliente</h4>
                <input type="text" id="searchInput" class="form-control border-0 shadow-sm" 
                    placeholder="Buscar por nombre, teléfono o DNI..." 
                    style="background-color: #e8c5c5; border-radius: 15px; padding: 12px 20px; font-size: 15px;">
            </div>
            <div class="text-center">
                <img src="/img/Clientes.png" alt="Clientes" style="width: 120px; height: auto;">
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="clientesTable" style="background-color: #faf5f5;">
                <thead style="background-color: #f0e5e5;">
                    <tr>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">ID</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Nombre</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">DNI</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Teléfono</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                    <tr style="border-bottom: 1px solid #f0e5e5;">
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $cliente->id }}</td>
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $cliente->dni }}</td>
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $cliente->telefono }}</td>
                        <td class="text-center py-3">
                            <div class="d-flex gap-2 justify-content-center">
                                <!-- Botón Mostrar (Amarillo) -->
                                <button class="btn btn-sm showBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #ffd700; border: none;"
                                    data-nombre="{{ $cliente->nombre }}"
                                    data-apellido="{{ $cliente->apellido }}"
                                    data-dni="{{ $cliente->dni }}"
                                    data-telefono="{{ $cliente->telefono }}"
                                    data-direccion="{{ $cliente->direccion }}"
                                    data-correo="{{ $cliente->correo }}"
                                    title="Ver detalles">
                                    <i class="bi bi-eye" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Editar (Verde) -->
                                <button class="btn btn-sm editBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #4ade80; border: none;"
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $cliente->id }}"
                                    data-nombre="{{ $cliente->nombre }}"
                                    data-apellido="{{ $cliente->apellido }}"
                                    data-dni="{{ $cliente->dni }}"
                                    data-telefono="{{ $cliente->telefono }}"
                                    data-direccion="{{ $cliente->direccion }}"
                                    data-correo="{{ $cliente->correo }}"
                                    title="Editar">
                                    <i class="bi bi-pencil" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Eliminar (Rojo) -->
                                <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center" 
                                        style="width: 36px; height: 36px; background-color: #ef4444; border: none;"
                                        onclick="return confirm('¿Estás seguro de eliminar este cliente?')"
                                        title="Eliminar">
                                        <i class="bi bi-trash" style="color: #fff; font-size: 16px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Mostrar Cliente -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detalles del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <strong>Nombre:</strong>
                    <p class="mb-0" id="show_nombre"></p>
                </div>
                <div class="mb-3">
                    <strong>Apellido:</strong>
                    <p class="mb-0" id="show_apellido"></p>
                </div>
                <div class="mb-3">
                    <strong>DNI:</strong>
                    <p class="mb-0" id="show_dni"></p>
                </div>
                <div class="mb-3">
                    <strong>Teléfono:</strong>
                    <p class="mb-0" id="show_telefono"></p>
                </div>
                <div class="mb-3">
                    <strong>Dirección:</strong>
                    <p class="mb-0" id="show_direccion"></p>
                </div>
                <div class="mb-3">
                    <strong>Correo:</strong>
                    <p class="mb-0" id="show_correo"></p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Cliente -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Apellido</label>
                        <input type="text" name="apellido" id="edit-apellido" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">DNI</label>
                        <input type="text" name="dni" id="edit-dni" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" name="telefono" id="edit-telefono" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dirección</label>
                        <input type="text" name="direccion" id="edit-direccion" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo</label>
                        <input type="email" name="correo" id="edit-correo" class="form-control" required style="border-radius: 10px;">
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

<!-- Modal Agregar Cliente -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form action="{{ route('cliente.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Apellido</label>
                        <input type="text" name="apellido" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">DNI</label>
                        <input type="text" name="dni" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dirección</label>
                        <input type="text" name="direccion" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo</label>
                        <input type="email" name="correo" class="form-control" required style="border-radius: 10px;">
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
            const nombre = row.cells[1].textContent.toLowerCase();
            const dni = row.cells[2].textContent.toLowerCase();
            const telefono = row.cells[3].textContent.toLowerCase();

            if (nombre.includes(filter) || dni.includes(filter) || telefono.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection