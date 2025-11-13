@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header con botón -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold mb-0">Usuarios</h2>
        <button class="btn btn-secondary px-3 py-2" data-bs-toggle="modal" data-bs-target="#createModal" style="background: #A674C9">
            <i class="bi bi-plus-circle me-2"></i>Agregar usuario
        </button>
    </div>

    <!-- Tarjeta de búsqueda -->
    <div class="card shadow-sm mb-4 border-0" style="background: linear-gradient(135deg, #f8e8e8 0%, #f3d4d4 100%); border-radius: 20px;">
        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between p-3 gap-3">
            <div class="flex-grow-1 w-100" style="max-width: 600px;">
                <h4 class="fw-bold mb-3">Buscar Usuario</h4>
                <input type="text" id="searchInput" class="form-control border-0 shadow-sm" 
                    placeholder="Buscar por nombre o correo..." 
                    style="background-color: #e8c5c5; border-radius: 15px; padding: 12px 20px; font-size: 15px;">
            </div>
            <div class="text-center d-none d-md-block">
                <img src="/img/Usuarios.png" alt="Usuarios" style="width: 120px; height: auto;">
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="usersTable" style="background-color: #faf5f5;">
                <thead style="background-color: #f0e5e5;">
                    <tr>
                        <th class="fw-bold text-center py-3 d-none d-md-table-cell" style="color: #000000ff;">ID</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Nombre</th>
                        <th class="fw-bold text-center py-3 d-none d-lg-table-cell" style="color: #000000ff;">Correo</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr style="border-bottom: 1px solid #f0e5e5;">
                        <td class="text-center py-3 d-none d-md-table-cell" style="color: #7F7A7A;">{{ $user->id }}</td>
                        <td class="text-center py-3" style="color: #7F7A7A;">
                            <div class="fw-semibold">{{ $user->name }}</div>
                            <small class="text-muted d-lg-none">{{ $user->email }}</small>
                        </td>
                        <td class="text-center py-3 d-none d-lg-table-cell" style="color: #7F7A7A;">{{ $user->email }}</td>
                        <td class="text-center py-3">
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <!-- Botón Mostrar (Amarillo) -->
                                <button class="btn btn-sm showBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #ffd700; border: none;"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-provider="{{ $user->provider ?? 'Email/Contraseña' }}"
                                    title="Ver detalles">
                                    <i class="bi bi-eye" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Editar (Verde) -->
                                <button class="btn btn-sm editBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #4ade80; border: none;"
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    title="Editar">
                                    <i class="bi bi-pencil" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Eliminar (Rojo) -->
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center" 
                                        style="width: 36px; height: 36px; background-color: #ef4444; border: none;"
                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
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

<!-- Modal Mostrar Usuario -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <strong>Nombre:</strong>
                    <p class="mb-0" id="show_name"></p>
                </div>
                <div class="mb-3">
                    <strong>Correo:</strong>
                    <p class="mb-0" id="show_email"></p>
                </div>
                <div class="mb-3">
                    <strong>Método de acceso:</strong>
                    <p class="mb-0" id="show_provider"></p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo</label>
                        <input type="email" name="email" id="edit-email" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nueva Contraseña</label>
                        <input type="password" name="password" id="edit-password" class="form-control" placeholder="Dejar vacío para no cambiar" style="border-radius: 10px;">
                        <small class="text-muted">Solo completa si deseas cambiar la contraseña</small>
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

<!-- Modal Agregar Usuario -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="name" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo</label>
                        <input type="email" name="email" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contraseña</label>
                        <input type="password" name="password" class="form-control" required style="border-radius: 10px;">
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
            document.getElementById('show_name').textContent = this.dataset.name;
            document.getElementById('show_email').textContent = this.dataset.email;
            document.getElementById('show_provider').textContent = this.dataset.provider;
            showModal.show();
        });
    });

    // Editar Modal
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('edit-name').value = button.dataset.name;
        document.getElementById('edit-email').value = button.dataset.email;
        document.getElementById('edit-password').value = '';
        document.getElementById('editForm').action = `/user/${button.dataset.id}`;
    });

    // Filtro dinámico
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
            const name = row.cells[1]?.textContent.toLowerCase() || '';
            const emailCell = row.cells[2]?.textContent.toLowerCase() || '';
            const emailSmall = row.querySelector('.text-muted')?.textContent.toLowerCase() || '';

            if (name.includes(filter) || emailCell.includes(filter) || emailSmall.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection