@extends('layouts.principal')

@section('titulo', 'Dashboard')

@section('contenido')
<div class="container-fluid">
    <!-- Welcome -->
    <div class="alert alert-success bg-gradient-success text-white border-0 mb-4">
        <h3 class="mb-1">¡Bienvenido, {{ Auth::user()->name }}!</h3>
        <p class="mb-0">Centro de control de inventario de la farmacia</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ number_format($totalProductos) }}</h3>
                        <p class="text-muted mb-0">Productos en Stock</p>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded p-3">
                        <i class="fas fa-box fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ number_format($totalVentas) }}</h3>
                        <p class="text-muted mb-0">Ventas Realizadas</p>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-3">
                        <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ number_format($totalClientes) }}</h3>
                        <p class="text-muted mb-0">Clientes Registrados</p>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded p-3">
                        <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ number_format($productosAgotados) }}</h3>
                        <p class="text-muted mb-0">Productos Agotados</p>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded p-3">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos con Bajo Stock -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>Productos con Bajo Stock (Stock < 10)
                    </h5>
                </div>
                <div class="card-body">
                    @if($productosBajoStock->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productosBajoStock as $producto)
                                    <tr>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>
                                            @if($producto->stock <= 0)
                                                <span class="badge bg-danger">Agotado</span>
                                            @elseif($producto->stock <= 5)
                                                <span class="badge bg-danger">{{ $producto->stock }} unidades</span>
                                            @else
                                                <span class="badge bg-warning">{{ $producto->stock }} unidades</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No hay productos con bajo stock</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Productos Más Vendidos -->
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-success">
                        <i class="fas fa-trophy me-2"></i>Productos Más Vendidos
                    </h5>
                </div>
                <div class="card-body">
                    @if($productosMasVendidos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Unidades Vendidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productosMasVendidos as $producto)
                                    <tr>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td><span class="badge bg-success">{{ $producto->total_vendido }} unidades</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No hay ventas registradas aún</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Ventas por Mes -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-chart-line me-2"></i>Ventas por Mes (Últimos 6 meses)
                    </h5>
                </div>
                <div class="card-body">
                    @if($ventasPorMes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mes</th>
                                        <th>Cantidad de Ventas</th>
                                        <th>Monto Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventasPorMes as $venta)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($venta->mes)->format('F Y') }}</td>
                                        <td><span class="badge bg-info">{{ $venta->total_ventas }} ventas</span></td>
                                        <td>${{ number_format($venta->monto_total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No hay ventas registradas aún</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection