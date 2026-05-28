@extends('layouts.principal')

@section('titulo', 'Dashboard')

@section('contenido')
<div class="welcome-section fade-in">
    <h2>¡Bienvenido, <span id="nombreBienvenida"></span>!</h2>
    <p>Este es tu centro de control de inventario. Gestiona tus productos, clientes, proveedores y más desde un solo lugar.</p>
</div>

<div class="stats-row">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="stats-card slide-up" style="animation-delay: 0.1s">
                <div class="stats-info">
                    <h3 class="counter" id="totalProductos">156</h3>
                    <p>Productos en Stock</p>
                    <div class="trend-indicator trend-up">12% vs mes anterior</div>
                </div>
                <div class="stats-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--primary-color);">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="stats-card slide-up" style="animation-delay: 0.2s">
                <div class="stats-info">
                    <h3 class="counter" id="totalVentas">89</h3>
                    <p>Cantidad de Ventas</p>
                    <div class="trend-indicator trend-up">8% vs mes anterior</div>
                </div>
                <div class="stats-icon" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-color);">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="stats-card slide-up" style="animation-delay: 0.3s">
                <div class="stats-info">
                    <h3 class="counter" id="totalClientes">45</h3>
                    <p>Clientes Registrados</p>
                    <div class="trend-indicator trend-up">5% vs mes anterior</div>
                </div>
                <div class="stats-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="stats-card slide-up" style="animation-delay: 0.4s">
                <div class="stats-info">
                    <h3 class="counter" id="totalAgotados">8</h3>
                    <p>Productos Agotados</p>
                    <div class="trend-indicator trend-down">2 vs mes anterior</div>
                </div>
                <div class="stats-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card low-stock-card">
            <h3><i class="fas fa-exclamation-circle me-2"></i>Productos con Bajo Stock</h3>
            <div class="product-list">
                <div class="product-item">
                    <img src="https://via.placeholder.com/80" class="product-image" alt="Paracetamol">
                    <p>Paracetamol 500mg</p>
                    <p class="stock">Stock actual: 2</p>
                </div>
                <div class="product-item">
                    <img src="https://via.placeholder.com/80" class="product-image" alt="Ibuprofeno">
                    <p>Ibuprofeno 400mg</p>
                    <p class="stock">Stock actual: 5</p>
                </div>
                <div class="product-item">
                    <img src="https://via.placeholder.com/80" class="product-image" alt="Amoxicilina">
                    <p>Amoxicilina 500mg</p>
                    <p class="stock">Stock actual: 3</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="dashboard-card top-sellers-card">
            <h3><i class="fas fa-trophy me-2"></i>Productos Más Vendidos</h3>
            <div class="product-list">
                <div class="product-item">
                    <img src="https://via.placeholder.com/80" class="product-image" alt="Amoxicilina">
                    <p>Amoxicilina 500mg</p>
                    <p class="sales">Ventas: 45</p>
                </div>
                <div class="product-item">
                    <img src="https://via.placeholder.com/80" class="product-image" alt="Omeprazol">
                    <p>Omeprazol 20mg</p>
                    <p class="sales">Ventas: 32</p>
                </div>
                <div class="product-item">
                    <img src="https://via.placeholder.com/80" class="product-image" alt="Losartán">
                    <p>Losartán 50mg</p>
                    <p class="sales">Ventas: 28</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.8/countUp.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const usuario = JSON.parse(localStorage.getItem('usuarioActual'));
        if (usuario) {
            document.getElementById('nombreBienvenida').innerText = usuario.nombre;
        }
        
        const counters = [
            { id: 'totalProductos', value: 156 },
            { id: 'totalVentas', value: 89 },
            { id: 'totalClientes', value: 45 },
            { id: 'totalAgotados', value: 8 }
        ];
        
        counters.forEach(counter => {
            const element = document.getElementById(counter.id);
            if (element) {
                new CountUp(element, 0, counter.value, 0, 2, {
                    useEasing: true,
                    useGrouping: true,
                    separator: ','
                }).start();
            }
        });
    });
</script>
@endpush