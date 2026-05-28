@extends('layouts.principal')

@section('titulo', 'Editar Compra')

@section('contenido')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Compra #{{ $compra->id_compra }}</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('compras.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
                    </a>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('compras.update', $compra->id_compra) }}" id="formCompra">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="proveedor_id" class="form-label">Proveedor *</label>
                                <select id="proveedor_id" name="proveedor_id" class="form-select" required>
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id_proveedor }}" {{ $compra->proveedor_id == $proveedor->id_proveedor ? 'selected' : '' }}>
                                            {{ $proveedor->nombre }} - {{ $proveedor->nit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fecha" class="form-label">Fecha *</label>
                                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ old('fecha', $compra->fecha) }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="hora" class="form-label">Hora *</label>
                                <input type="time" id="hora" name="hora" class="form-control" value="{{ old('hora', $compra->hora) }}" required>
                            </div>
                        </div>

                        @php
                            $detalle = $compra->detalleCompras->first();
                            $producto = $detalle->producto;
                        @endphp

                        <div class="mb-3">
                            <label class="form-label">Tipo de Producto *</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_producto" id="productoExistente" value="existente" {{ $detalle->producto_id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="productoExistente">Producto Existente</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_producto" id="productoNuevo" value="nuevo" {{ !$detalle->producto_id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="productoNuevo">Producto Nuevo</label>
                                </div>
                            </div>
                        </div>

                        <!-- Producto Existente -->
                        <div id="divProductoExistente" style="{{ $detalle->producto_id ? 'display: block;' : 'display: none;' }}">
                            <div class="mb-3">
                                <label for="producto_id" class="form-label">Producto *</label>
                                <select id="producto_id" name="producto_id" class="form-select">
                                    <option value="">Seleccione un producto</option>
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->id_producto }}" 
                                            data-precio="{{ $prod->precio }}"
                                            {{ $detalle->producto_id == $prod->id_producto ? 'selected' : '' }}>
                                            {{ $prod->nombre }} - Código: {{ $prod->codigo }} - Stock actual: {{ $prod->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Producto Nuevo -->
                        <div id="divProductoNuevo" style="{{ !$detalle->producto_id ? 'display: block;' : 'display: none;' }}">
                            <div class="mb-3">
                                <label for="codigo" class="form-label">Código del Producto *</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" value="{{ !$detalle->producto_id ? $producto->codigo : '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Nombre del Producto *</label>
                                <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" value="{{ !$detalle->producto_id ? $producto->nombre : '' }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <select id="categoria" name="categoria" class="form-select">
                                        <option value="">Seleccione</option>
                                        <option value="Analgésico" {{ isset($producto) && $producto->categoria == 'Analgésico' ? 'selected' : '' }}>Analgésico</option>
                                        <option value="Antiinflamatorio" {{ isset($producto) && $producto->categoria == 'Antiinflamatorio' ? 'selected' : '' }}>Antiinflamatorio</option>
                                        <option value="Antibiótico" {{ isset($producto) && $producto->categoria == 'Antibiótico' ? 'selected' : '' }}>Antibiótico</option>
                                        <option value="Antiácido" {{ isset($producto) && $producto->categoria == 'Antiácido' ? 'selected' : '' }}>Antiácido</option>
                                        <option value="Antihipertensivo" {{ isset($producto) && $producto->categoria == 'Antihipertensivo' ? 'selected' : '' }}>Antihipertensivo</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="laboratorio" class="form-label">Laboratorio</label>
                                    <input type="text" id="laboratorio" name="laboratorio" class="form-control" value="{{ !$detalle->producto_id ? $producto->laboratorio : '' }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="presentacion" class="form-label">Presentación</label>
                                <select id="presentacion" name="presentacion" class="form-select">
                                    <option value="">Seleccione</option>
                                    <option value="Tableta" {{ isset($producto) && $producto->presentacion == 'Tableta' ? 'selected' : '' }}>Tableta</option>
                                    <option value="Cápsula" {{ isset($producto) && $producto->presentacion == 'Cápsula' ? 'selected' : '' }}>Cápsula</option>
                                    <option value="Jarabe" {{ isset($producto) && $producto->presentacion == 'Jarabe' ? 'selected' : '' }}>Jarabe</option>
                                    <option value="Inyectable" {{ isset($producto) && $producto->presentacion == 'Inyectable' ? 'selected' : '' }}>Inyectable</option>
                                    <option value="Crema" {{ isset($producto) && $producto->presentacion == 'Crema' ? 'selected' : '' }}>Crema</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label">Precio *</label>
                                <input type="number" step="0.01" id="precio" name="precio" class="form-control" value="{{ old('precio', $detalle->precio_unitario) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cantidad" class="form-label">Cantidad *</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" value="{{ old('cantidad', $detalle->cantidad) }}" required min="1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" step="0.01" id="total" class="form-control" value="{{ $detalle->subtotal }}" readonly>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-save me-2"></i>Actualizar Compra
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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