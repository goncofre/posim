@extends('adminlte::page')

@section('title', 'Productos - POSIM')

@section('content_header')
    <h1>Crear Producto</h1>
@stop

@section('content')
    <div class="container">
        <h1>Crear Nuevo Producto</h1>
        
        <div class="card shadow-sm">
            <div class="card-header">
                Formulario de Registro
            </div>
            <div class="card-body">
                
                {{-- Formulario que apunta a la ruta 'productos.store' (método POST) --}}
                <form action="{{ route('productos.store') }}" method="POST">
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

                    {{-- 1. SKU --}}
                    <div class="form-group mb-3">
                        <label for="sku">SKU (Código de Producto) *</label>
                        <input type="text" name="sku" id="sku" 
                               class="form-control @error('sku') is-invalid @enderror" 
                               value="{{ old('sku') }}" required>
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 2. Nombre del Producto --}}
                    <div class="form-group mb-3">
                        <label for="nombre_producto">Nombre del Producto *</label>
                        <input type="text" name="nombre_producto" id="nombre_producto" 
                               class="form-control @error('nombre_producto') is-invalid @enderror" 
                               value="{{ old('nombre_producto') }}" required>
                        @error('nombre_producto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Categoría --}}
                    <div class="form-group mb-3">
                        <label for="categoria_id">Categoría</label>
                        <select name="categoria_id" id="categoria_id" 
                                class="form-control @error('categoria_id') is-invalid @enderror">
                            <option value="">-- Seleccione una Categoría --</option>
                            
                            {{-- Bucle para mostrar las categorías disponibles --}}
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" 
                                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                            
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 4. Tipo de Producto --}}
                    <div class="form-group mb-3">
                        <label for="tipo_producto">Tipo de Producto *</label>
                        <select name="tipo_producto" id="tipo_producto" 
                                class="form-control @error('tipo_producto') is-invalid @enderror" required>
                            <option value="unitario" {{ old('tipo_producto') == 'unitario' ? 'selected' : '' }}>Unitario (Por Unidad)</option>
                            <option value="granel" {{ old('tipo_producto') == 'granel' ? 'selected' : '' }}>Granel (Por Peso/Medida)</option>
                        </select>
                        @error('tipo_producto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 5. Precio de Venta --}}
                    <div class="form-group mb-4">
                        <label for="precio_venta">Precio de Venta *</label>
                        <input type="number" name="precio_venta" id="precio_venta" 
                               class="form-control @error('precio_venta') is-invalid @enderror" 
                               value="{{ old('precio_venta') }}" step="0.01" min="0.01" required>
                        @error('precio_venta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr>

                    {{-- Botones de Acción --}}
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style></style>
@stop

@section('js')
    <script></script>
@stop