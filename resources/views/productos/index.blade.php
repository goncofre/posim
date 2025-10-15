@extends('adminlte::page')

@section('title', 'Productos - POSIM')

@section('content_header')
    <h1>Productos</h1>
@stop

@section('content')
    <div class="container">
        {{-- Botón para Crear Nuevo Producto --}}
        <div class="mb-4 text-right">
            <a href="{{ route('productos.create') }}" class="btn btn-success">
                Crear Nuevo Producto
            </a>
        </div>

        {{-- Mensajes de Sesión (Éxito o Error) --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Tabla de Productos --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th>Precio Venta</th>
                                <th style="width: 150px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td><strong>{{ $producto->sku }}</strong></td>
                                    <td>{{ $producto->nombre_producto }}</td>
                                    <td>{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</td> 
                                    {{-- Usa la relación 'categoria' que definiste en el modelo --}}
                                    <td>
                                        <span class="badge {{ $producto->tipo_producto == 'unitario' ? 'bg-primary' : 'bg-info' }}">
                                            {{ ucfirst($producto->tipo_producto) }}
                                        </span>
                                    </td>
                                    <td>$ {{ number_format($producto->precio_venta, 0) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </foarm>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay productos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Solución para el tamaño de los íconos de paginación de Laravel en Bootstrap */
        .pagination .page-link svg {
            width: 1em;
            height: 1em;
        }

        /* Ajuste para alinear correctamente el texto y los íconos */
        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@stop

@section('js')
    <script></script>
@stop