@extends('adminlte::page') 

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Packs de Productos</h1>
        <a href="{{ route('packs.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Crear Nuevo Pack
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Nombre del Pack</th>
                        <th>Precio de Venta</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packs as $pack)
                        <tr>
                            <td>{{ $pack->id }}</td>
                            <td>{{ $pack->sku }}</td>
                            <td>{{ $pack->nombre_pack }}</td>
                            <td>${{ number_format($pack->precio_venta, 2) }}</td>
                            <td>
                                @if ($pack->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('packs.edit', $pack) }}" class="btn btn-sm btn-info text-white me-2" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Aquí iría el formulario para DELETE --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay packs de productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center">
                {{ $packs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection