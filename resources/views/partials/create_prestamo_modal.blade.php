<div class="modal fade" id="createPrestamoModal" tabindex="-1">
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
                            <option value="">Seleccione un libro disponible</option>
                            @foreach($libros_disponibles as $libro)
                                <option value="{{ $libro->id }}">{{ $libro->titulo }}</option>
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
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
