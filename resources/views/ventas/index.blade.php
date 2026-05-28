@extends('layouts.principal')

@section('titulo', 'Ventas')

@section('contenido')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-cash-register me-2"></i>Lista de Ventas</h2>
        <a href="{{ route('ventas.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nueva Venta
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $venta->hora }}</td>
                            <td>{{ $venta->cliente->nombre }}</td>
                            <td>
                                @foreach($venta->detalleVentas as $detalle)
                                    {{ $detalle->cantidad }} x {{ $detalle->producto->nombre }}<br>
                                @endforeach
                            </td>
                            <td>${{ number_format($venta->total, 2) }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="eliminarVenta({{ $venta->id_venta }})">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay ventas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function eliminarVenta(id) {
    if (confirm('¿Eliminar esta venta? Se restaurará el stock de los productos.')) {
        fetch(`/ventas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Error al eliminar la venta');
            }
        });
    }
}
</script>
@endsection