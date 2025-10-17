@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Crear Nueva Ubicación</h1>
            <hr>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    Detalles de la Sucursal/Bodega
                </div>
                <div class="card-body">
                    <form action="{{ route('sucursales.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            {{-- Tipo de Ubicación --}}
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo de Ubicación <span class="text-danger">*</span></label>
                                <select id="tipo" name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                    <option value="">Seleccione...</option>
                                    {{-- $tipos viene del controlador: ['sucursal' => 'Sucursal (Punto de Venta)', 'bodega' => 'Bodega (Almacenamiento)'] --}}
                                    @foreach ($tipos as $key => $value)
                                        <option value="{{ $key }}" {{ old('tipo') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Nombre --}}
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            {{-- Dirección --}}
                            <div class="col-12">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion') }}">
                                @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Comuna y Región --}}
                            <div class="col-md-6">
                                <label for="comuna" class="form-label">Comuna</label>
                                <input type="text" class="form-control @error('comuna') is-invalid @enderror" id="comuna" name="comuna" value="{{ old('comuna') }}">
                                @error('comuna') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="region" class="form-label">Región</label>
                                <input type="text" class="form-control @error('region') is-invalid @enderror" id="region" name="region" value="{{ old('region') }}">
                                @error('region') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Teléfono y Email --}}
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}">
                                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('sucursales.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Ubicación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection