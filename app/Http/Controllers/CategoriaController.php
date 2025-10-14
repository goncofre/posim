<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::latest()->paginate(10);
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'estado' => 'sometimes|boolean',
        ]);

        // Aseguramos que el estado se guarde correctamente, por defecto activo (true)
        $validatedData['estado'] = $request->boolean('estado');

        Categoria::create($validatedData);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validatedData = $request->validate([
            // Ignoramos el nombre de la categoría actual para la validación de unicidad
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id, 
            'estado' => 'sometimes|boolean',
        ]);
        
        $validatedData['estado'] = $request->boolean('estado');

        $categoria->update($validatedData);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        // Nota: Si hay productos asociados, la relación debe manejarse (e.g., eliminarlos o establecer category_id en NULL)
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}