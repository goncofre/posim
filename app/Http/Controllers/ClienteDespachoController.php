<?php

namespace App\Http\Controllers;

use App\Models\ClienteDespacho;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteDespachoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = ClienteDespacho::latest()->paginate(10);
        return view('clientes_despacho.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes_despacho.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            // El RUT/Fiscal puede ser único o nulo
            'rut_fiscal' => ['nullable', 'string', 'max:50', Rule::unique('cliente_despachos', 'rut_fiscal')], 
            'direccion_despacho' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        ClienteDespacho::create($validatedData);

        return redirect()->route('clientes_despacho.index')->with('success', 'Cliente registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClienteDespacho $clienteDespacho)
    {
        return view('clientes_despacho.show', compact('clienteDespacho'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClienteDespacho $clienteDespacho)
    {
        return view('clientes_despacho.edit', compact('clienteDespacho'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClienteDespacho $clienteDespacho)
    {
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'rut_fiscal' => ['nullable', 'string', 'max:50', Rule::unique('cliente_despachos', 'rut_fiscal')->ignore($clienteDespacho->id)],
            'direccion_despacho' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $clienteDespacho->update($validatedData);

        return redirect()->route('clientes_despacho.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClienteDespacho $clienteDespacho)
    {
        $clienteDespacho->delete();

        return redirect()->route('clientes_despacho.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}