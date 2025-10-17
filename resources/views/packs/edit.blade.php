@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h1>Editar Pack: {{ $pack->nombre_pack }}</h1>
            <hr>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5>Errores de Validación:</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('packs.update', $pack) }}" method="POST">
                @csrf
                @method('PUT') {{-- Método para actualización --}}

                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        Datos del Pack
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nombre_pack" class="form-label">Nombre del Pack</label>
                                <input type="text" class="form-control" id="nombre_pack" name="nombre_pack" value="{{ old('nombre_pack', $pack->nombre_pack) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sku" class="form-label">SKU del Pack</label>
                                {{-- Permite modificar el SKU, pero debe ser único --}}
                                <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $pack->sku) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="precio_venta" class="form-label">Precio de Venta del Pack ($)</label>
                                <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" value="{{ old('precio_venta', $pack->precio_venta) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $pack->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">Pack Activo</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-secondary text-white">
                        Contenido del Pack
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="producto_selector" class="form-label">Agregar Producto al Pack:</label>
                            <select id="producto_selector" class="form-select">
                                <option value="">Selecciona un Producto...</option>
                                @foreach ($productos as $producto)
                                    <option 
                                        value="{{ $producto->id }}" 
                                        data-sku="{{ $producto->sku }}" 
                                        data-nombre="{{ $producto->nombre_producto }}"
                                    >
                                        {{ $producto->sku }} - {{ $producto->nombre_producto }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm btn-info mt-2 text-white" id="agregarItemBtn">
                                <i class="fas fa-plus"></i> Añadir
                            </button>
                        </div>

                        <table class="table table-bordered" id="packItemsTable">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Producto</th>
                                    <th style="width: 150px;">Cantidad</th>
                                    <th style="width: 100px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Las filas se insertarán y precargarán con JavaScript --}}
                            </tbody>
                        </table>
                        <input type="hidden" name="items" id="itemsArrayInput">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sync-alt"></i> Actualizar Pack</button>
                    <a href="{{ route('packs.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // 💡 Inicialización con los datos existentes del pack
    let packItems = @json($pack->items->map(function ($item) {
        return [
            'producto_id' => $item->producto_id,
            'sku' => $item->sku,
            'nombre' => $item->producto->nombre_producto, // Asume que cargaste la relación 'producto'
            'cantidad' => $item->cantidad
        ];
    }));
    
    // Código de la vista create.blade.php (renderItemRow, handleCantidadChange, handleRemoveItem, syncHiddenInput)
    // DEBES COPIAR Y PEGAR LAS FUNCIONES AUXILIARES COMPLETAS AQUÍ
    
    // ... (Copiar funciones auxiliares aquí: renderItemRow, handleCantidadChange, handleRemoveItem, syncHiddenInput) ...

    const selector = document.getElementById('producto_selector');
    const tableBody = document.getElementById('packItemsTable').querySelector('tbody');
    const itemsArrayInput = document.getElementById('itemsArrayInput');
    
    // Función para renderizar todos los ítems al inicio
    function loadExistingItems() {
        packItems.forEach(item => renderItemRow(item));
        syncHiddenInput();
    }
    
    document.addEventListener('DOMContentLoaded', loadExistingItems);

    // Lógica para agregar un nuevo ítem (igual que en create.blade.php)
    document.getElementById('agregarItemBtn').addEventListener('click', function() {
        // ... (Lógica de agregar producto, igual que en create.blade.php) ...
    });

    // Código para el manejo de errores de validación (similar a create.blade.php)
    @if($errors->any() && old('items'))
        // ... (Lógica de recarga de old('items') aquí) ...
    @endif
    
</script>
@endsection