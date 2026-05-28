@extends('layouts.principal')

@section('titulo', 'Editar Cliente')

@section('contenido')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Cliente</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
                    </a>

                    <form method="POST" action="{{ route('clientes.update', $cliente->id_cliente) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input type="text" id="cedula" class="form-control" value="{{ $cliente->cedula }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cliente->nombre) }}" required>
                            @error('nombre')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $cliente->email) }}" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <input type="text" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $cliente->telefono) }}" required>
                            @error('telefono')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-save me-2"></i>Actualizar Cliente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection