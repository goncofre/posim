@extends('layouts.app')

@section('title', 'Gestión de Clientes para Despacho')

@section('content')
    <div class="container">
        <h1>Clientes para Despacho 🚚</h1>
        
        {{-- Botón para Crear Nuevo Cliente --}}
        <div class="mb-4 text-right">
            <a href="{{ route('clientes_despacho.create') }}" class="btn btn-success">
                Crear Nuevo Cliente
            </a>
        </div>

        {{-- Mensajes de Sesión --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Tabla de Clientes --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>RUT/ID Fiscal</th>
                                <th>Dirección de Despacho</th>
                                <th>Teléfono</th>
                                <th style="width: 150px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Bucle de Blade para recorrer los clientes --}}
                            @forelse ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td><strong>{{ $cliente->nombre_completo }}</strong></td>
                                    <td>{{ $cliente->rut_fiscal ?? 'N/A' }}</td>
                                    <td>{{ $cliente->direccion_despacho }}</td>
                                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            
                                            {{-- Botón Editar --}}
                                            <a href="{{ route('clientes_despacho.edit', $cliente->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Botón Eliminar (Formulario DELETE) --}}
                                            <form action="{{ route('clientes_despacho.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay clientes de despacho registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-3">
                    {{ $clientes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection