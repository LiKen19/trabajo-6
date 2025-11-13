<div class="modal fade" id="createClienteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cliente.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Cliente</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
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
                        <label>Correo</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    
                    <!-- CAMPO AGREGADO -->
                    <div class="mb-3">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
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