@extends('layouts.principal')

@section('titulo', 'Nueva Venta')

@section('contenido')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Registrar Nueva Venta</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
                    </a>

                    <form method="POST" action="{{ route('ventas.store') }}" id="formVenta">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cliente_id" class="form-label">Cliente *</label>
                                <select id="cliente_id" name="cliente_id" class="form-select" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre }} - {{ $cliente->cedula }}</option>
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

                        <hr>
                        <h5 class="mb-3">Productos</h5>
                        
                        <div id="productos-container">
                            <div class="row producto-item mb-2">
                                <div class="col-md-5">
                                    <select name="producto_id[]" class="form-select producto-select" required>
                                        <option value="">Seleccione un producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}">
                                                {{ $producto->nombre }} - Código: {{ $producto->codigo }} - Stock: {{ $producto->stock }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="precio[]" class="form-control precio-input" placeholder="Precio" step="0.01" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="cantidad[]" class="form-control cantidad-input" placeholder="Cantidad" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control subtotal-input" placeholder="Subtotal" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-eliminar-producto">X</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="btnAgregarProducto" class="btn btn-info mb-3">
                            <i class="fas fa-plus me-2"></i>Agregar Producto
                        </button>

                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Total: $<span id="total-venta">0.00</span></h5>
                                        <input type="hidden" name="total" id="total-hidden">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-3">
                            <i class="fas fa-save me-2"></i>Registrar Venta
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

    let productoIndex = 1;

    function calcularSubtotal(fila) {
        const precio = parseFloat(fila.querySelector('.precio-input').value) || 0;
        const cantidad = parseFloat(fila.querySelector('.cantidad-input').value) || 0;
        const subtotal = precio * cantidad;
        fila.querySelector('.subtotal-input').value = subtotal.toFixed(2);
        calcularTotalGeneral();
    }

    function calcularTotalGeneral() {
        let total = 0;
        document.querySelectorAll('.subtotal-input').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total-venta').innerText = total.toFixed(2);
        document.getElementById('total-hidden').value = total.toFixed(2);
    }

    function actualizarPrecio(select) {
        const fila = select.closest('.producto-item');
        const precio = select.options[select.selectedIndex].getAttribute('data-precio');
        if (precio) {
            fila.querySelector('.precio-input').value = precio;
            calcularSubtotal(fila);
        }
    }

    function validarStock(select) {
        const fila = select.closest('.producto-item');
        const stock = parseInt(select.options[select.selectedIndex].getAttribute('data-stock')) || 0;
        const cantidadInput = fila.querySelector('.cantidad-input');
        
        cantidadInput.addEventListener('change', function() {
            const cantidad = parseInt(this.value) || 0;
            if (cantidad > stock) {
                alert(`Stock insuficiente. Solo hay ${stock} unidades disponibles.`);
                this.value = stock;
                calcularSubtotal(fila);
            }
        });
    }

    document.getElementById('btnAgregarProducto').addEventListener('click', function() {
        const container = document.getElementById('productos-container');
        const template = document.querySelector('.producto-item').cloneNode(true);
        
        template.querySelectorAll('input').forEach(input => input.value = '');
        template.querySelector('.producto-select').value = '';
        template.querySelector('.subtotal-input').value = '';
        
        container.appendChild(template);
        
        const newSelect = template.querySelector('.producto-select');
        newSelect.addEventListener('change', function() {
            actualizarPrecio(this);
            validarStock(this);
        });
        
        template.querySelector('.precio-input').addEventListener('input', function() {
            calcularSubtotal(template);
        });
        
        template.querySelector('.cantidad-input').addEventListener('input', function() {
            calcularSubtotal(template);
        });
        
        template.querySelector('.btn-eliminar-producto').addEventListener('click', function() {
            if (document.querySelectorAll('.producto-item').length > 1) {
                template.remove();
                calcularTotalGeneral();
            } else {
                alert('Debe haber al menos un producto');
            }
        });
    });

    document.querySelectorAll('.producto-select').forEach(select => {
        select.addEventListener('change', function() {
            actualizarPrecio(this);
            validarStock(this);
        });
    });

    document.querySelectorAll('.precio-input, .cantidad-input').forEach(input => {
        input.addEventListener('input', function() {
            calcularSubtotal(this.closest('.producto-item'));
        });
    });

    document.querySelectorAll('.btn-eliminar-producto').forEach(btn => {
        btn.addEventListener('click', function() {
            const fila = this.closest('.producto-item');
            if (document.querySelectorAll('.producto-item').length > 1) {
                fila.remove();
                calcularTotalGeneral();
            } else {
                alert('Debe haber al menos un producto');
            }
        });
    });

    document.getElementById('formVenta').addEventListener('submit', function(e) {
        const productos = document.querySelectorAll('.producto-select');
        let valido = true;
        
        productos.forEach(select => {
            if (!select.value) {
                alert('Debe seleccionar un producto para cada fila');
                valido = false;
            }
        });
        
        if (!valido) {
            e.preventDefault();
        }
    });
</script>
@endsection