import './bootstrap';
// ============================================
// MODO OSCURO
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const toggleModoOscuro = document.getElementById('modoOscuroToggle');
    
    // Verificar preferencia guardada
    const modoOscuro = localStorage.getItem('modoOscuro') === 'true';
    if (modoOscuro) {
        document.body.classList.add('modo-oscuro');
        if (toggleModoOscuro) toggleModoOscuro.checked = true;
    }
    
    // Evento para cambiar modo oscuro
    if (toggleModoOscuro) {
        toggleModoOscuro.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('modo-oscuro');
                localStorage.setItem('modoOscuro', 'true');
            } else {
                document.body.classList.remove('modo-oscuro');
                localStorage.setItem('modoOscuro', 'false');
            }
        });
    }
});

// ============================================
// SELECT2 INICIALIZACIÓN
// ============================================
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Seleccione una opción',
        language: {
            noResults: function() {
                return "No se encontraron resultados";
            },
            searching: function() {
                return "Buscando...";
            }
        }
    });
});

// ============================================
// CÁLCULO DE PRECIOS EN VENTAS/COMPRAS
// ============================================
function calcularTotal() {
    const cantidad = parseFloat(document.getElementById('cantidad')?.value) || 0;
    const precioUnitario = parseFloat(document.getElementById('precio_unitario')?.value) || 0;
    const precioTotal = cantidad * precioUnitario;
    
    const totalInput = document.getElementById('precio_total');
    if (totalInput) {
        totalInput.value = precioTotal.toFixed(2);
    }
}

function calcularTotalCompra() {
    const precioProducto = parseFloat(document.getElementById('precio_producto')?.value) || 0;
    const cantidad = parseFloat(document.getElementById('cantidad')?.value) || 0;
    const precioTotal = precioProducto * cantidad;
    
    const totalInput = document.getElementById('precio_total');
    if (totalInput) {
        totalInput.value = precioTotal.toFixed(2);
    }
}

// Asignar eventos si existen los elementos
document.addEventListener('DOMContentLoaded', function() {
    const cantidadInput = document.getElementById('cantidad');
    const precioUnitarioInput = document.getElementById('precio_unitario');
    const precioProductoInput = document.getElementById('precio_producto');
    
    if (cantidadInput && precioUnitarioInput) {
        cantidadInput.addEventListener('input', calcularTotal);
        precioUnitarioInput.addEventListener('input', calcularTotal);
    }
    
    if (cantidadInput && precioProductoInput) {
        cantidadInput.addEventListener('input', calcularTotalCompra);
        precioProductoInput.addEventListener('input', calcularTotalCompra);
    }
});

// ============================================
// VALIDACIÓN DE STOCK EN VENTAS
// ============================================
function validarStock(event, stockDisponible, cantidadVenta) {
    if (stockDisponible - cantidadVenta === 1) {
        if (!confirm('¡Alerta! El producto tendrá solo 1 unidad en stock después de esta venta. ¿Deseas continuar?')) {
            event.preventDefault();
            return false;
        }
    }
    return true;
}

// ============================================
// PREVISUALIZACIÓN DE IMAGEN
// ============================================
function previsualizarImagen(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ============================================
// CONFIRMAR ELIMINACIÓN
// ============================================
function confirmarEliminacion(event) {
    if (!confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')) {
        event.preventDefault();
        return false;
    }
    return true;
}

// Asignar confirmación a todos los formularios de eliminación
document.addEventListener('DOMContentLoaded', function() {
    const formulariosEliminar = document.querySelectorAll('.form-eliminar');
    formulariosEliminar.forEach(form => {
        form.addEventListener('submit', confirmarEliminacion);
    });
});

// Modo oscuro
document.addEventListener('DOMContentLoaded', function() {
    const darkMode = localStorage.getItem('darkMode') === 'true';
    if (darkMode) {
        document.body.classList.add('dark-mode');
        const toggle = document.getElementById('darkModeToggle');
        if (toggle) toggle.checked = true;
    }
});

// Confirmar eliminación
function confirmarEliminacion(event) {
    if (!confirm('¿Estás seguro de eliminar este registro?')) {
        event.preventDefault();
        return false;
    }
    return true;
}

// Inicializar Select2
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Seleccione una opción'
    });
});