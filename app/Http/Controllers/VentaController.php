<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra una lista de todas las ventas.
     */
    public function index()
    {
        $ventas = Venta::with('user')->latest()->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear una nueva venta.
     */
    public function create()
    {
        // Pasar modelos necesarios para el formulario, ej: Usuarios
        // $users = \App\Models\User::all();
        return view('ventas.create');
    }

    /**
     * Store a newly created resource in storage.
     * Guarda una nueva venta en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'estado' => 'sometimes|string|in:pendiente,finalizada,cancelada',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // 2. Creación de la venta
        Venta::create($validatedData);

        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     * Muestra una venta específica.
     */
    public function show(Venta $venta)
    {
        // Se inyecta la instancia de Venta automáticamente (Route Model Binding)
        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar una venta.
     */
    public function edit(Venta $venta)
    {
        return view('ventas.edit', compact('venta'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza una venta específica en la base de datos.
     */
    public function update(Request $request, Venta $venta)
    {
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'estado' => 'sometimes|string|in:pendiente,finalizada,cancelada',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // 2. Actualización de la venta
        $venta->update($validatedData);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina una venta específica de la base de datos.
     */
    public function destroy(Venta $venta)
    {
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }
}
