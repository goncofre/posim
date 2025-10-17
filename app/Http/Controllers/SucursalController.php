<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SucursalController extends Controller
{
    /**
     * Muestra una lista de todas las sucursales y bodegas.
     */
    public function index()
    {
        $sucursales = Sucursal::orderBy('nombre')->paginate(10);
        return view('sucursales.index', compact('sucursales'));
    }

    /**
     * Muestra el formulario para crear una nueva sucursal/bodega.
     */
    public function create()
    {
        $tipos = ['sucursal' => 'Sucursal (Punto de Venta)', 'bodega' => 'Bodega (Almacenamiento)'];
        return view('sucursales.create', compact('tipos'));
    }

    /**
     * Almacena una nueva sucursal o bodega.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:sucursales,nombre',
            'direccion' => 'nullable|string|max:255',
            'comuna' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tipo' => ['required', Rule::in(['sucursal', 'bodega'])],
        ]);

        Sucursal::create($validatedData);

        return redirect()->route('sucursales.index')
                         ->with('success', 'Ubicación (' . $validatedData['tipo'] . ') creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar la sucursal/bodega.
     */
    public function edit(Sucursal $sucursal)
    {
        $tipos = ['sucursal' => 'Sucursal (Punto de Venta)', 'bodega' => 'Bodega (Almacenamiento)'];
        return view('sucursales.edit', compact('sucursal', 'tipos'));
    }

    /**
     * Actualiza la sucursal o bodega específica.
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        $validatedData = $request->validate([
            // La validación unique debe ignorar el registro actual
            'nombre' => ['required', 'string', 'max:255', Rule::unique('sucursales', 'nombre')->ignore($sucursal->id)],
            'direccion' => 'nullable|string|max:255',
            'comuna' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tipo' => ['required', Rule::in(['sucursal', 'bodega'])],
        ]);

        $sucursal->update($validatedData);

        return redirect()->route('sucursales.index')
                         ->with('success', 'Ubicación actualizada exitosamente.');
    }

    /**
     * Elimina la sucursal o bodega.
     */
    public function destroy(Sucursal $sucursal)
    {
        // NOTA: Implementar validación aquí para no eliminar si hay inventario/ventas asociadas.
        try {
            $sucursal->delete();
            return redirect()->route('sucursales.index')->with('success', 'Ubicación eliminada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se puede eliminar la ubicación porque tiene registros asociados.');
        }
    }
}