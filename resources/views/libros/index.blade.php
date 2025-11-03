@extends('layouts.app')

@section('title', 'Libros')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">Gestión de Libros</h2>

    <!-- Filtro y Botón Agregar en la misma línea -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <!-- Filtro a la izquierda -->
        <input type="text" id="searchInput" class="form-control me-2 mb-2 mb-md-0" style="max-width: 300px;" placeholder="Buscar libro...">

        <!-- Botón Agregar a la derecha -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Agregar libro
        </button>
    </div>

    <!-- Tabla simplificada: Título, Categoría, Estado -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle" id="librosTable">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($libros as $libro)
                <tr>
                    <td>{{ $libro->titulo }}</td>
                    <td>{{ $libro->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $libro->estado }}</td>
                    <td class="d-flex gap-1 flex-wrap">
                        <!-- Botón Mostrar -->
                        <button class="btn btn-info btn-sm showBtn"
                            data-titulo="{{ $libro->titulo }}"
                            data-categoria="{{ $libro->categoria->nombre ?? 'Sin categoría' }}"
                            data-idioma="{{ $libro->idioma }}"
                            data-autor="{{ $libro->autor }}"
                            data-editorial="{{ $libro->editorial }}"
                            data-estado="{{ $libro->estado }}">
                            Mostrar
                        </button>

                        <!-- Botón Editar -->
                        <button class="btn btn-warning btn-sm editBtn"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="{{ $libro->id }}"
                            data-titulo="{{ $libro->titulo }}"
                            data-categoria_id="{{ $libro->categoria_id }}"
                            data-idioma="{{ $libro->idioma }}"
                            data-autor="{{ $libro->autor }}"
                            data-editorial="{{ $libro->editorial }}"
                            data-estado="{{ $libro->estado }}">
                            Editar
                        </button>

                        <!-- Botón Eliminar -->
                        <form action="{{ route('libro.destroy', $libro->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger btn-sm" value="Eliminar">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Mostrar Libro (completo) -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Título:</strong> <span id="show_titulo"></span></p>
                <p><strong>Categoría:</strong> <span id="show_categoria"></span></p>
                <p><strong>Idioma:</strong> <span id="show_idioma"></span></p>
                <p><strong>Autor:</strong> <span id="show_autor"></span></p>
                <p><strong>Editorial:</strong> <span id="show_editorial"></span></p>
                <p><strong>Estado:</strong> <span id="show_estado"></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Libro (completo) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Título</label>
                        <input type="text" name="titulo" id="edit-titulo" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Categoría</label>
                        <select name="categoria_id" id="edit-categoria" class="form-control">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Idioma</label>
                        <input type="text" name="idioma" id="edit-idioma" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Autor</label>
                        <input type="text" name="autor" id="edit-autor" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Editorial</label>
                        <input type="text" name="editorial" id="edit-editorial" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Crear Libro -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/libro') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Categoría</label>
                        <select name="categoria_id" class="form-control" required>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Idioma</label>
                        <input type="text" name="idioma" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Autor</label>
                        <input type="text" name="autor" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Editorial</label>
                        <input type="text" name="editorial" class="form-control" required>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar modal
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

    // Editar modal
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const titulo = button.getAttribute('data-titulo');
        const categoria_id = button.getAttribute('data-categoria_id');
        const idioma = button.getAttribute('data-idioma');
        const autor = button.getAttribute('data-autor');
        const editorial = button.getAttribute('data-editorial');
        const estado = button.getAttribute('data-estado');

        editModal.querySelector('#edit-titulo').value = titulo;
        editModal.querySelector('#edit-categoria').value = categoria_id;
        editModal.querySelector('#edit-idioma').value = idioma;
        editModal.querySelector('#edit-autor').value = autor;
        editModal.querySelector('#edit-editorial').value = editorial;
        editModal.querySelector('#edit-estado').value = estado;

        editModal.querySelector('#editForm').action = `/libro/${id}`;
    });

    // Filtro dinámico
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#librosTable tbody tr');

        rows.forEach(row => {
            const titulo = row.cells[0].textContent.toLowerCase();
            const categoria = row.cells[1].textContent.toLowerCase();
            const estado = row.cells[2].textContent.toLowerCase();

            row.style.display = (titulo.includes(filter) || categoria.includes(filter) || estado.includes(filter)) ? '' : 'none';
        });
    });
});
</script>
@endsection
