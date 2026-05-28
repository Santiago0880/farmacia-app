@extends('layouts.principal')

@section('titulo', 'Compras')

@section('contenido')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-shopping-cart me-2"></i>Lista de Compras</h2>
        <a href="{{ route('compras.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nueva Compra
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
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
                            <th>Proveedor</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($compras as $compra)
                            @foreach($compra->detalleCompras as $detalle)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $compra->detalleCompras->count() }}">{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                                        <td rowspan="{{ $compra->detalleCompras->count() }}">{{ $compra->hora }}</td>
                                        <td rowspan="{{ $compra->detalleCompras->count() }}">{{ $compra->proveedor->nombre }}</td>
                                    @endif
                                    <td>{{ $detalle->producto->nombre }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td>${{ number_format($detalle->subtotal, 2) }}</td>
                                    @if($loop->first)
                                        <td rowspan="{{ $compra->detalleCompras->count() }}">
                                            <button class="btn btn-danger btn-sm" onclick="eliminarCompra({{ $compra->id_compra }})">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay compras registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function eliminarCompra(id) {
    if (confirm('¿Eliminar esta compra? Se descontará el stock de los productos.')) {
        fetch(`/compras/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Error al eliminar la compra');
            }
        });
    }
}
</script>
@endsection