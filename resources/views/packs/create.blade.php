@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h1>Crear Nuevo Pack de Productos</h1>
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

            <form action="{{ route('packs.store') }}" method="POST">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        Datos del Pack
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nombre_pack" class="form-label">Nombre del Pack</label>
                                <input type="text" class="form-control" id="nombre_pack" name="nombre_pack" value="{{ old('nombre_pack') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sku" class="form-label">SKU del Pack</label>
                                <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku') }}" required>
                                <small class="text-muted">Código único para identificar el pack.</small>
                            </div>
                            <div class="col-md-4">
                                <label for="precio_venta" class="form-label">Precio de Venta del Pack ($)</label>
                                <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" value="{{ old('precio_venta') }}" required>
                                <small class="text-muted">Precio final de venta del pack.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-secondary text-white">
                        Contenido del Pack (Mínimo 2 Ítems)
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="producto_selector" class="form-label">Agregar Producto al Pack:</label>
                            <select id="producto_selector" class="form-select">
                                <option value="">Selecciona un Producto...</option>
                                {{-- $productos viene del controlador --}}
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
                                {{-- Las filas se insertarán con JavaScript --}}
                            </tbody>
                        </table>
                        <input type="hidden" name="items" id="itemsArrayInput">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Guardar Pack</button>
                    <a href="{{ route('packs.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let packItems = [];
    const selector = document.getElementById('producto_selector');
    const tableBody = document.getElementById('packItemsTable').querySelector('tbody');
    const itemsArrayInput = document.getElementById('itemsArrayInput');

    document.getElementById('agregarItemBtn').addEventListener('click', function() {
        const selectedOption = selector.options[selector.selectedIndex];
        if (!selectedOption.value) return;

        const id = selectedOption.value;
        const sku = selectedOption.dataset.sku;
        const nombre = selectedOption.dataset.nombre;

        // Verificar si el producto ya está en el pack
        let existingItem = packItems.find(item => item.producto_id == id);

        if (existingItem) {
            // Si existe, incrementamos la cantidad solo en el array (la tabla se actualiza manualmente)
            existingItem.cantidad += 1;
            document.getElementById(`cantidad-${id}`).value = existingItem.cantidad;
        } else {
            // Si no existe, lo añadimos al array y a la tabla
            const newItem = {
                producto_id: id,
                sku: sku,
                nombre: nombre,
                cantidad: 1 
            };
            packItems.push(newItem);
            renderItemRow(newItem);
        }
        
        // Sincronizar el array con el input hidden para Laravel
        syncHiddenInput();
        
        // Volver a seleccionar la opción por defecto
        selector.value = "";
    });

    // Renderiza una nueva fila en la tabla
    function renderItemRow(item) {
        const row = tableBody.insertRow();
        row.id = `row-${item.producto_id}`;

        row.innerHTML = `
            <td>${item.sku}</td>
            <td>${item.nombre}</td>
            <td>
                <input type="number" class="form-control form-control-sm item-cantidad" 
                       id="cantidad-${item.producto_id}" 
                       value="${item.cantidad}" 
                       min="1" 
                       data-id="${item.producto_id}" 
                       required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger eliminar-item-btn" data-id="${item.producto_id}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        // Asignar listeners a los nuevos elementos
        row.querySelector('.item-cantidad').addEventListener('change', handleCantidadChange);
        row.querySelector('.eliminar-item-btn').addEventListener('click', handleRemoveItem);
    }

    // Maneja el cambio en el campo de cantidad
    function handleCantidadChange(event) {
        const id = event.target.dataset.id;
        const nuevaCantidad = parseInt(event.target.value);

        if (nuevaCantidad < 1) {
            event.target.value = 1; // Previene cantidades negativas
            return;
        }

        const item = packItems.find(i => i.producto_id == id);
        if (item) {
            item.cantidad = nuevaCantidad;
            syncHiddenInput();
        }
    }

    // Maneja la eliminación de un ítem
    function handleRemoveItem(event) {
        const id = event.currentTarget.dataset.id;
        
        // 1. Eliminar del array JS
        packItems = packItems.filter(item => item.producto_id != id);

        // 2. Eliminar de la tabla DOM
        document.getElementById(`row-${id}`).remove();

        // 3. Sincronizar
        syncHiddenInput();
    }

    // Sincroniza el array JS con el input hidden para que Laravel lo reciba
    function syncHiddenInput() {
        itemsArrayInput.value = JSON.stringify(packItems.map(item => ({
            producto_id: item.producto_id,
            sku: item.sku,
            cantidad: item.cantidad
            // No necesitamos enviar el nombre, Laravel solo necesita los IDs/SKU/Cantidad
        })));
    }
    
    // Si hay datos antiguos del formulario (error de validación), cargarlos
    @if(old('items'))
        packItems = JSON.parse('{!! addslashes(old('items')) !!}');
        packItems.forEach(item => {
            // Necesitamos buscar el nombre del producto para renderizar
            const productoData = Array.from(selector.options).find(opt => opt.value == item.producto_id);
            if(productoData) {
                item.nombre = productoData.dataset.nombre;
                renderItemRow(item);
            }
        });
        syncHiddenInput();
    @endif
    
</script>
@endsection