@extends('layouts.principal')

@section('titulo', 'Nueva Compra')

@section('contenido')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-cart-plus me-2"></i>Registrar Nueva Compra</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('compras.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
                    </a>

                    <form method="POST" action="{{ route('compras.store') }}" id="formCompra">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="proveedor_id" class="form-label">Proveedor *</label>
                                <select id="proveedor_id" name="proveedor_id" class="form-select" required>
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre }} - {{ $proveedor->nit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" id="fecha" name="fecha" class="form-control" readonly style="background-color: #e9ecef;">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="hora" class="form-label">Hora</label>
                                <input type="time" id="hora" name="hora" class="form-control" readonly style="background-color: #e9ecef;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Producto *</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_producto" id="productoExistente" value="existente" checked>
                                    <label class="form-check-label" for="productoExistente">Producto Existente</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_producto" id="productoNuevo" value="nuevo">
                                    <label class="form-check-label" for="productoNuevo">Producto Nuevo</label>
                                </div>
                            </div>
                        </div>

                        <!-- Producto Existente -->
                        <div id="divProductoExistente">
                            <div class="mb-3">
                                <label for="producto_id" class="form-label">Producto *</label>
                                <select id="producto_id" name="producto_id" class="form-select">
                                    <option value="">Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio }}">
                                            {{ $producto->nombre }} - Código: {{ $producto->codigo }} - Stock: {{ $producto->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Producto Nuevo -->
                        <div id="divProductoNuevo" style="display: none;">
                            <div class="mb-3">
                                <label for="codigo" class="form-label">Código del Producto *</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Ej: P001, MED-001">
                            </div>

                            <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Nombre del Producto *</label>
                                <input type="text" id="nombre_producto" name="nombre_producto" class="form-control">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <select id="categoria" name="categoria" class="form-select">
                                        <option value="">Seleccione</option>
                                        <option value="Analgésico">Analgésico</option>
                                        <option value="Antiinflamatorio">Antiinflamatorio</option>
                                        <option value="Antibiótico">Antibiótico</option>
                                        <option value="Antiácido">Antiácido</option>
                                        <option value="Antihipertensivo">Antihipertensivo</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="laboratorio" class="form-label">Laboratorio</label>
                                    <input type="text" id="laboratorio" name="laboratorio" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="presentacion" class="form-label">Presentación</label>
                                <select id="presentacion" name="presentacion" class="form-select">
                                    <option value="">Seleccione</option>
                                    <option value="Tableta">Tableta</option>
                                    <option value="Cápsula">Cápsula</option>
                                    <option value="Jarabe">Jarabe</option>
                                    <option value="Inyectable">Inyectable</option>
                                    <option value="Crema">Crema</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label">Precio *</label>
                                <input type="number" step="0.01" id="precio" name="precio" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cantidad" class="form-label">Cantidad *</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" required min="1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" step="0.01" id="total" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-2"></i>Registrar Compra
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para actualizar fecha y hora automáticamente
    function actualizarFechaHora() {
        const ahora = new Date();
        const fecha = ahora.toISOString().split('T')[0];
        const hora = ahora.toTimeString().split(' ')[0].substring(0, 5);
        
        document.getElementById('fecha').value = fecha;
        document.getElementById('hora').value = hora;
    }
    
    // Actualizar cada segundo
    actualizarFechaHora();
    setInterval(actualizarFechaHora, 1000);

    // Mostrar/ocultar según tipo de producto
    document.querySelectorAll('input[name="tipo_producto"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'existente') {
                document.getElementById('divProductoExistente').style.display = 'block';
                document.getElementById('divProductoNuevo').style.display = 'none';
                document.getElementById('producto_id').required = true;
                document.getElementById('codigo').required = false;
                document.getElementById('nombre_producto').required = false;
                document.getElementById('categoria').required = false;
                document.getElementById('laboratorio').required = false;
                document.getElementById('presentacion').required = false;
            } else {
                document.getElementById('divProductoExistente').style.display = 'none';
                document.getElementById('divProductoNuevo').style.display = 'block';
                document.getElementById('producto_id').required = false;
                document.getElementById('codigo').required = true;
                document.getElementById('nombre_producto').required = true;
                document.getElementById('categoria').required = true;
                document.getElementById('laboratorio').required = true;
                document.getElementById('presentacion').required = true;
            }
            calcularTotal();
        });
    });

    // Actualizar precio según producto seleccionado
    document.getElementById('producto_id').addEventListener('change', function() {
        const precio = this.options[this.selectedIndex].getAttribute('data-precio');
        if (precio) {
            document.getElementById('precio').value = precio;
            calcularTotal();
        }
    });

    // Calcular total
    function calcularTotal() {
        const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
        const precio = parseFloat(document.getElementById('precio').value) || 0;
        document.getElementById('total').value = (cantidad * precio).toFixed(2);
    }

    document.getElementById('cantidad').addEventListener('input', calcularTotal);
    document.getElementById('precio').addEventListener('input', calcularTotal);
</script>
@endsection