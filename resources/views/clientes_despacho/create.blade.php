@extends('layouts.app')

@section('title', 'Crear Nuevo Cliente de Despacho')

@section('content')
    <div class="container">
        <h1>Registrar Nuevo Cliente</h1>
        
        <div class="card shadow-sm">
            <div class="card-header">
                Datos de Contacto y Despacho
            </div>
            <div class="card-body">
                
                {{-- Formulario que apunta a la ruta 'clientes_despacho.store' (método POST) --}}
                <form action="{{ route('clientes_despacho.store') }}" method="POST">
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

                    {{-- 1. Nombre Completo --}}
                    <div class="form-group mb-3">
                        <label for="nombre_completo">Nombre Completo *</label>
                        <input type="text" name="nombre_completo" id="nombre_completo" 
                               class="form-control @error('nombre_completo') is-invalid @enderror" 
                               value="{{ old('nombre_completo') }}" required>
                        @error('nombre_completo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 2. RUT/ID Fiscal --}}
                    <div class="form-group mb-3">
                        <label for="rut_fiscal">RUT/ID Fiscal (Opcional)</label>
                        <input type="text" name="rut_fiscal" id="rut_fiscal" 
                               class="form-control @error('rut_fiscal') is-invalid @enderror" 
                               value="{{ old('rut_fiscal') }}">
                        @error('rut_fiscal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Dirección de Despacho --}}
                    <div class="form-group mb-3">
                        <label for="direccion_despacho">Dirección de Despacho *</label>
                        <input type="text" name="direccion_despacho" id="direccion_despacho" 
                               class="form-control @error('direccion_despacho') is-invalid @enderror" 
                               value="{{ old('direccion_despacho') }}" required>
                        @error('direccion_despacho')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 4. Teléfono --}}
                    <div class="form-group mb-3">
                        <label for="telefono">Teléfono (Opcional)</label>
                        <input type="tel" name="telefono" id="telefono" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- 5. Email --}}
                    <div class="form-group mb-4">
                        <label for="email">Email (Opcional)</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr>

                    {{-- Botones de Acción --}}
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                    <a href="{{ route('clientes_despacho.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection