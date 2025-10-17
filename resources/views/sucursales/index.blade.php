@extends('adminlte::page') 

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Sucursales y Bodegas</h1>
        <a href="{{ route('sucursales.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Crear Nueva Ubicación
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
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sucursales as $sucursal)
                        <tr>
                            <td>{{ $sucursal->id }}</td>
                            <td>{{ $sucursal->nombre }}</td>
                            <td>
                                @if ($sucursal->tipo === 'sucursal')
                                    <span class="badge bg-primary"><i class="fas fa-store"></i> Sucursal</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-warehouse"></i> Bodega</span>
                                @endif
                            </td>
                            <td>{{ $sucursal->direccion }}, {{ $sucursal->comuna }}</td>
                            <td>{{ $sucursal->telefono }}</td>
                            <td>
                                <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-sm btn-info text-white" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('sucursales.destroy', $sucursal) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta ubicación? Esta acción es irreversible.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay sucursales ni bodegas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center">
                {{ $sucursales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection