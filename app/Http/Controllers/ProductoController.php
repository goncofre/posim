<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra una lista de todos los productos.
     */
    public function index()
    {
        $productos = Producto::with('categoria')->latest()->paginate(15);
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        // Ejemplo: Pasar las categorías para el select del formulario
        $categorias = \App\Models\Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     * Guarda un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sku' => 'required|string|max:50|unique:productos,sku',
            'nombre_producto' => 'required|string|max:255',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tipo_producto' => 'required|in:unitario,granel',
            'precio_venta' => 'required|numeric|min:0.01',
        ]);

        Producto::create($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     * Muestra un producto específico.
     */
    public function show(Producto $producto)
    {
        // Route Model Binding: Laravel busca el producto automáticamente por ID
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar un producto.
     */
    public function edit(Producto $producto)
    {
        $categorias = \App\Models\Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza un producto específico en la base de datos.
     */
    public function update(Request $request, Producto $producto)
    {
        $validatedData = $request->validate([
            // La validación unique se ajusta para ignorar el SKU del producto actual
            'sku' => 'required|string|max:50|unique:productos,sku,' . $producto->id, 
            'nombre_producto' => 'required|string|max:255',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tipo_producto' => 'required|in:unitario,granel',
            'precio_venta' => 'required|numeric|min:0.01',
        ]);

        $producto->update($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina un producto específico de la base de datos.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}