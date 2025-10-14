@extends('adminlte::page')

@section('title', 'Usuarios - POSIM')

@section('content')
    <div class="container">
        <h1>Crear Nuevo Usuario</h1>
        
        <div class="card shadow-sm">
            <div class="card-header">
                Formulario de Registro
            </div>
            <div class="card-body">
                
                {{-- Formulario que apunta a la ruta 'users.store' (método POST) --}}
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    {{-- Mensajes de error de validación --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- 1. Nombre --}}
                    <div class="form-group mb-3">
                        <label for="name">Nombre *</label>
                        <input type="text" name="name" id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 2. Email --}}
                    <div class="form-group mb-3">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Contraseña --}}
                    <div class="form-group mb-3">
                        <label for="password">Contraseña *</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- 4. Confirmar Contraseña (para la regla 'confirmed') --}}
                    <div class="form-group mb-4">
                        <label for="password_confirmation">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" required>
                    </div>
                    
                    <hr>

                    {{-- Botones de Acción --}}
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection