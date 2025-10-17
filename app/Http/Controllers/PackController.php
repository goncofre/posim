<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\PackItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PackController extends Controller
{
    public function index()
    {
        $packs = Pack::with('items.producto')->paginate(10);
        return view('packs.index', compact('packs'));
    }
    
    public function create()
    {
        // Necesitas pasar los productos disponibles a la vista
        $productos = \App\Models\Producto::select('id', 'sku', 'nombre_producto', 'precio_venta')->get();
        return view('packs.create', compact('productos'));
    }

    /**
     * Almacena un pack y sus items en una transacción.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:packs,sku'],
            'nombre_pack' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            // El array de items debe tener al menos 2 productos
            'items' => 'required|array|min:2', 
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.sku' => 'required|string|max:50',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 1. Crear el Pack (Encabezado)
            $pack = Pack::create([
                'sku' => $validatedData['sku'],
                'nombre_pack' => $validatedData['nombre_pack'],
                'precio_venta' => $validatedData['precio_venta'],
                'activo' => true,
            ]);

            // 2. Preparar los Items (Detalle)
            $itemsData = array_map(function ($item) use ($pack) {
                return [
                    'pack_id' => $pack->id,
                    'producto_id' => $item['producto_id'],
                    'sku' => $item['sku'],
                    'cantidad' => $item['cantidad'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $validatedData['items']);

            // 3. Insertar los Items
            PackItem::insert($itemsData);

            DB::commit();

            return redirect()->route('packs.index')->with('success', 'Pack de productos creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear el pack: ' . $e->getMessage());
        }
    }

    public function edit(Pack $pack)
    {
        $pack->load('items.producto'); 

        $productos = \App\Models\Producto::select('id', 'sku', 'nombre_producto', 'precio_venta')->get();

        return view('packs.edit', compact('pack', 'productos'));
    }
    
    // ... (Métodos show, update, destroy similares al ClienteDespachoController) ...
    // Nota: El método update necesitará usar la lógica de transacción y eliminar/insertar los items si cambian.
    /*
        Lógica del update: El método update del controlador debe ser más complejo que el store. Deberás:
        a. Actualizar el registro de Pack principal.
        b. Eliminar todos los registros antiguos de PackItem asociados al pack ($pack->items()->delete();).
        c. Insertar todos los nuevos ítems de la venta recibidos en $request->items (PackItem::insert($itemsData);).
        d. Todo esto, dentro de una transacción de base de datos (DB::beginTransaction()).
    */
}