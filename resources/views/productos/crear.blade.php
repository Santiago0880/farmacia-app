@extends('layouts.principal')

@section('titulo', 'Crear Producto')

@section('contenido')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-box-plus me-2"></i>Crear Nuevo Producto</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Volver a la Lista
                    </a>

                    <form method="POST" action="{{ route('productos.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigo" class="form-label">Código *</label>
                                <input type="text" id="codigo" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo') }}" required>
                                @error('codigo')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="precio" class="form-label">Precio *</label>
                                <input type="number" step="0.01" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}" required>
                                @error('precio')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" required>
                                @error('stock')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoría *</label>
                                <select id="categoria" name="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                                    <option value="">Seleccione</option>
                                    <option value="Analgésico">Analgésico</option>
                                    <option value="Antiinflamatorio">Antiinflamatorio</option>
                                    <option value="Antibiótico">Antibiótico</option>
                                    <option value="Antiácido">Antiácido</option>
                                    <option value="Antihipertensivo">Antihipertensivo</option>
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
                                    <option value="">Seleccione</option>
                                    <option value="Tableta">Tableta</option>
                                    <option value="Cápsula">Cápsula</option>
                                    <option value="Jarabe">Jarabe</option>
                                    <option value="Inyectable">Inyectable</option>
                                    <option value="Crema">Crema</option>
                                </select>
                                @error('presentacion')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="laboratorio" class="form-label">Laboratorio *</label>
                                <input type="text" id="laboratorio" name="laboratorio" class="form-control @error('laboratorio') is-invalid @enderror" value="{{ old('laboratorio') }}" required>
                                @error('laboratorio')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-2"></i>Guardar Producto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection