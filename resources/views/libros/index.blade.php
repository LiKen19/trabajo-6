@extends('layouts.app')

@section('title', 'Libros')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header con botón -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold mb-0">Libros</h2>
        <button class="btn btn-secondary px-3 py-2" data-bs-toggle="modal" data-bs-target="#createModal" style="background: #A674C9">
            <i class="bi bi-plus-circle me-2"></i>Agregar libro
        </button>
    </div>

    <!-- Tarjeta de búsqueda -->
    <div class="card shadow-sm mb-4 border-0" style="background: linear-gradient(135deg, #f8e8e8 0%, #f3d4d4 100%); border-radius: 20px;">
        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between p-3 gap-3">
            <div class="flex-grow-1 w-100" style="max-width: 600px;">
                <h4 class="fw-bold mb-3">Buscar Libro</h4>
                <input type="text" id="searchInput" class="form-control border-0 shadow-sm" 
                    placeholder="Buscar por título o estado..." 
                    style="background-color: #e8c5c5; border-radius: 15px; padding: 12px 20px; font-size: 15px;">
            </div>
            <div class="text-center d-none d-md-block">
                <img src="/img/Libros.png" alt="Libros" style="width: 120px; height: auto;">
            </div>
        </div>
    </div>

    <!-- Tabla de libros -->
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="librosTable" style="background-color: #faf5f5;">
                <thead style="background-color: #f0e5e5;">
                    <tr>
                        <th class="fw-bold text-center py-3 d-none d-md-table-cell" style="color: #000000ff;">ID</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Título</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Estado</th>
                        <th class="fw-bold text-center py-3" style="color: #000000ff;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($libros as $libro)
                    <tr style="border-bottom: 1px solid #f0e5e5;">
                        <td class="text-center py-3 d-none d-md-table-cell" style="color: #7F7A7A;">{{ $libro->id }}</td>
                        <td class="text-center py-3" style="color: #7F7A7A;">
                            <div class="fw-semibold">{{ $libro->titulo }}</div>
                            <small class="text-muted d-md-none">{{ $libro->categoria->nombre ?? 'Sin categoría' }}</small>
                        </td>
                        <td class="text-center py-3" style="color: #7F7A7A;">{{ $libro->estado }}</td>
                        <td class="text-center py-3">
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <!-- Botón Mostrar (Amarillo) -->
                                <button class="btn btn-sm showBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #ffd700; border: none;"
                                    data-titulo="{{ $libro->titulo }}"
                                    data-categoria="{{ $libro->categoria->nombre ?? 'Sin categoría' }}"
                                    data-idioma="{{ $libro->idioma }}"
                                    data-autor="{{ $libro->autor }}"
                                    data-editorial="{{ $libro->editorial }}"
                                    data-estado="{{ $libro->estado }}"
                                    title="Ver detalles">
                                    <i class="bi bi-eye" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Editar (Verde) -->
                                <button class="btn btn-sm editBtn d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; background-color: #4ade80; border: none;"
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $libro->id }}"
                                    data-titulo="{{ $libro->titulo }}"
                                    data-categoria_id="{{ $libro->categoria_id }}"
                                    data-idioma="{{ $libro->idioma }}"
                                    data-autor="{{ $libro->autor }}"
                                    data-editorial="{{ $libro->editorial }}"
                                    data-estado="{{ $libro->estado }}"
                                    title="Editar">
                                    <i class="bi bi-pencil" style="color: #fff; font-size: 16px;"></i>
                                </button>

                                <!-- Botón Eliminar (Rojo) -->
                                <form action="{{ route('libro.destroy', $libro->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center" 
                                        style="width: 36px; height: 36px; background-color: #ef4444; border: none;"
                                        onclick="return confirm('¿Estás seguro de eliminar este libro?')"
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

<!-- Modal Mostrar Libro -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detalles del Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <strong>Título:</strong>
                    <p class="mb-0" id="show_titulo"></p>
                </div>
                <div class="mb-3">
                    <strong>Categoría:</strong>
                    <p class="mb-0" id="show_categoria"></p>
                </div>
                <div class="mb-3">
                    <strong>Idioma:</strong>
                    <p class="mb-0" id="show_idioma"></p>
                </div>
                <div class="mb-3">
                    <strong>Autor:</strong>
                    <p class="mb-0" id="show_autor"></p>
                </div>
                <div class="mb-3">
                    <strong>Editorial:</strong>
                    <p class="mb-0" id="show_editorial"></p>
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

<!-- Modal Editar Libro -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Editar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Título</label>
                        <input type="text" name="titulo" id="edit-titulo" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Categoría</label>
                        <select name="categoria_id" id="edit-categoria" class="form-control" required style="border-radius: 10px;">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Idioma</label>
                        <input type="text" name="idioma" id="edit-idioma" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Autor</label>
                        <input type="text" name="autor" id="edit-autor" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Editorial</label>
                        <input type="text" name="editorial" id="edit-editorial" class="form-control" required style="border-radius: 10px;">
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

<!-- Modal Agregar Libro -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form action="{{ route('libro.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Agregar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Título</label>
                        <input type="text" name="titulo" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Categoría</label>
                        <select name="categoria_id" class="form-control" required style="border-radius: 10px;">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Idioma</label>
                        <input type="text" name="idioma" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Autor</label>
                        <input type="text" name="autor" class="form-control" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Editorial</label>
                        <input type="text" name="editorial" class="form-control" required style="border-radius: 10px;">
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
            document.getElementById('show_titulo').textContent = this.dataset.titulo;
            document.getElementById('show_categoria').textContent = this.dataset.categoria;
            document.getElementById('show_idioma').textContent = this.dataset.idioma;
            document.getElementById('show_autor').textContent = this.dataset.autor;
            document.getElementById('show_editorial').textContent = this.dataset.editorial;
            document.getElementById('show_estado').textContent = this.dataset.estado;
            showModal.show();
        });
    });

    // Editar Modal
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('edit-titulo').value = button.dataset.titulo;
        document.getElementById('edit-categoria').value = button.dataset.categoria_id;
        document.getElementById('edit-idioma').value = button.dataset.idioma;
        document.getElementById('edit-autor').value = button.dataset.autor;
        document.getElementById('edit-editorial').value = button.dataset.editorial;
        document.getElementById('editForm').action = `/libro/${button.dataset.id}`;
    });

    // Filtro dinámico
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#librosTable tbody tr');

        rows.forEach(row => {
            const titulo = row.cells[0].textContent.toLowerCase() + row.cells[1]?.textContent.toLowerCase();
            const estado = row.cells[2]?.textContent.toLowerCase() || '';

            if (titulo.includes(filter) || estado.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection