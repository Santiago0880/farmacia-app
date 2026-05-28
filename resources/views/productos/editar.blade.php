@extends('layouts.principal')

@section('titulo', 'Editar Producto')

@section('contenido')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fas fa-box-edit me-2"></i>Editar Producto</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
                    </a>

                    <form method="POST" action="{{ route('productos.update', $producto->id_producto) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" id="codigo" class="form-control" value="{{ $producto->codigo }}" readonly disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto->nombre) }}" required>
                                @error('nombre')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="precio" class="form-label">Precio *</label>
                                <input type="number" step="0.01" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio', $producto->precio) }}" required>
                                @error('precio')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $producto->stock) }}" required>
                                @error('stock')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoría *</label>
                                <select id="categoria" name="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                                    <option value="Analgésico" {{ $producto->categoria == 'Analgésico' ? 'selected' : '' }}>Analgésico</option>
                                    <option value="Antiinflamatorio" {{ $producto->categoria == 'Antiinflamatorio' ? 'selected' : '' }}>Antiinflamatorio</option>
                                    <option value="Antibiótico" {{ $producto->categoria == 'Antibiótico' ? 'selected' : '' }}>Antibiótico</option>
                                    <option value="Antiácido" {{ $producto->categoria == 'Antiácido' ? 'selected' : '' }}>Antiácido</option>
                                    <option value="Antihipertensivo" {{ $producto->categoria == 'Antihipertensivo' ? 'selected' : '' }}>Antihipertensivo</option>
                                </select>
                                @error('categoria')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="presentacion" class="form-label">Presentación *</label>
                                <select id="presentacion" name="presentacion" class="form-select @error('presentacion') is-invalid @enderror" required>
                                    <option value="Tableta" {{ $producto->presentacion == 'Tableta' ? 'selected' : '' }}>Tableta</option>
                                    <option value="Cápsula" {{ $producto->presentacion == 'Cápsula' ? 'selected' : '' }}>Cápsula</option>
                                    <option value="Jarabe" {{ $producto->presentacion == 'Jarabe' ? 'selected' : '' }}>Jarabe</option>
                                    <option value="Inyectable" {{ $producto->presentacion == 'Inyectable' ? 'selected' : '' }}>Inyectable</option>
                                    <option value="Crema" {{ $producto->presentacion == 'Crema' ? 'selected' : '' }}>Crema</option>
                                </select>
                                @error('presentacion')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="laboratorio" class="form-label">Laboratorio *</label>
                                <input type="text" id="laboratorio" name="laboratorio" class="form-control @error('laboratorio') is-invalid @enderror" value="{{ old('laboratorio', $producto->laboratorio) }}" required>
                                @error('laboratorio')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-save me-2"></i>Actualizar Producto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection