@extends('layouts.principal')

@section('titulo', 'Cambiar Contraseña')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="tarjeta-formulario">
            <h4 class="mb-4"><i class="fas fa-key me-2"></i>Cambiar Contraseña</h4>
            
            <form method="POST" action="{{ route('cambiar-contrasena.actualizar') }}">
                @csrf
                @method('PUT')
                
                <div class="grupo-formulario">
                    <label for="password_actual">Contraseña Actual</label>
                    <input type="password" id="password_actual" name="password_actual" class="control-formulario" required>
                    @error('password_actual')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="grupo-formulario">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password" id="password" name="password" class="control-formulario" required>
                    <small class="text-muted">Mínimo 8 caracteres</small>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="grupo-formulario">
                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="control-formulario" required>
                </div>
                
                <button type="submit" class="btn-agregar">
                    <i class="fas fa-save me-2"></i>Cambiar Contraseña
                </button>
            </form>
        </div>
    </div>
</div>
@endsection