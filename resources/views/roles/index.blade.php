@extends('layouts.principal')

@section('titulo', 'Gestión de Roles')

@section('contenido')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-shield me-2"></i>Gestión de Roles y Permisos</h2>
        <a href="/dashboard" class="btn btn-secondary">
            <i class="fas fa-home me-2"></i>Volver al Inicio
        </a>
    </div>

    <div class="row">
        <!-- Lista de Roles -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Roles del Sistema</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Rol Administrador -->
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-crown text-warning me-2"></i>
                                <strong>Administrador</strong>
                                <br>
                                <small class="text-muted">Acceso total al sistema</small>
                                <br>
                                <small class="text-muted">2 usuarios asignados</small>
                            </div>
                            <div>
                                <button class="btn btn-warning btn-sm" onclick="editarRol('administrador')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Rol Encargado de Inventario -->
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-boxes text-info me-2"></i>
                                <strong>Encargado de Inventario</strong>
                                <br>
                                <small class="text-muted">Acceso: Dashboard y Productos</small>
                                <br>
                                <small class="text-muted">2 usuarios asignados</small>
                            </div>
                            <div>
                                <button class="btn btn-warning btn-sm" onclick="editarRol('encargado_inventario')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Rol Vendedor -->
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-tie text-success me-2"></i>
                                <strong>Vendedor</strong>
                                <br>
                                <small class="text-muted">Acceso: Dashboard, Ventas, Clientes, Productos</small>
                                <br>
                                <small class="text-muted">3 usuarios asignados</small>
                            </div>
                            <div>
                                <button class="btn btn-warning btn-sm" onclick="editarRol('vendedor')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success w-100" onclick="nuevoRol()">
                        <i class="fas fa-plus me-2"></i>Nuevo Rol
                    </button>
                </div>
            </div>
        </div>

        <!-- Asignar Rol a Usuario -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user-tag me-2"></i>Asignar Rol a Usuario</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usuario</label>
                            <select id="usuario_id" class="form-select">
                                <option value="">Seleccione un usuario</option>
                                <option value="1">Ana Martínez (ana@farmacia.com)</option>
                                <option value="2">Carlos López (carlos@farmacia.com)</option>
                                <option value="3">Luisa Fernández (luisa@farmacia.com)</option>
                                <option value="4">Pedro Gómez (pedro@farmacia.com)</option>
                                <option value="5">Marta Ruiz (marta@farmacia.com)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rol</label>
                            <select id="rol_id" class="form-select">
                                <option value="">Seleccione un rol</option>
                                <option value="administrador">Administrador</option>
                                <option value="encargado_inventario">Encargado de Inventario</option>
                                <option value="vendedor">Vendedor</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-success w-100" onclick="asignarRol()">
                        <i class="fas fa-save me-2"></i>Asignar Rol
                    </button>
                </div>
            </div>

            <!-- Lista de Usuarios con sus Roles -->
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Usuarios y sus Roles</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Rol Actual</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ana Martínez</td>
                                    <td>ana@farmacia.com</td>
                                    <td><span class="badge bg-warning text-dark">Administrador</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="removerRol(1)">
                                            <i class="fas fa-times"></i> Remover Rol
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Carlos López</td>
                                    <td>carlos@farmacia.com</td>
                                    <td><span class="badge bg-info">Encargado de Inventario</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="removerRol(2)">
                                            <i class="fas fa-times"></i> Remover Rol
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Luisa Fernández</td>
                                    <td>luisa@farmacia.com</td>
                                    <td><span class="badge bg-success">Vendedor</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="removerRol(3)">
                                            <i class="fas fa-times"></i> Remover Rol
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pedro Gómez</td>
                                    <td>pedro@farmacia.com</td>
                                    <td><span class="badge bg-success">Vendedor</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="removerRol(4)">
                                            <i class="fas fa-times"></i> Remover Rol
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Marta Ruiz</td>
                                    <td>marta@farmacia.com</td>
                                    <td><span class="badge bg-info">Encargado de Inventario</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="removerRol(5)">
                                            <i class="fas fa-times"></i> Remover Rol
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar rol -->
<div class="modal fade" id="modalEditarRol" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Editar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Nombre del Rol</label>
                <input type="text" id="nombreRol" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="guardarEdicionRol()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    let rolEditando = null;
    
    function asignarRol() {
        const usuario = document.getElementById('usuario_id').value;
        const rol = document.getElementById('rol_id').value;
        
        if (!usuario || !rol) {
            alert('Seleccione un usuario y un rol');
            return;
        }
        
        alert('Rol asignado correctamente (demo)');
        location.reload();
    }
    
    function removerRol(id) {
        if (confirm('¿Estás seguro de remover este rol?')) {
            alert('Rol removido (demo)');
            location.reload();
        }
    }
    
    function nuevoRol() {
        const nombre = prompt('Ingrese el nombre del nuevo rol:');
        if (nombre) {
            alert(`Rol "${nombre}" creado (demo)`);
            location.reload();
        }
    }
    
    function editarRol(rol) {
        rolEditando = rol;
        let nombreMostrar = '';
        if (rol === 'administrador') nombreMostrar = 'Administrador';
        else if (rol === 'encargado_inventario') nombreMostrar = 'Encargado de Inventario';
        else if (rol === 'vendedor') nombreMostrar = 'Vendedor';
        else nombreMostrar = rol;
        
        document.getElementById('nombreRol').value = nombreMostrar;
        new bootstrap.Modal(document.getElementById('modalEditarRol')).show();
    }
    
    function guardarEdicionRol() {
        const nuevoNombre = document.getElementById('nombreRol').value;
        if (nuevoNombre) {
            alert(`Rol actualizado a "${nuevoNombre}" (demo)`);
            bootstrap.Modal.getInstance(document.getElementById('modalEditarRol')).hide();
            location.reload();
        }
    }
</script>
@endsection