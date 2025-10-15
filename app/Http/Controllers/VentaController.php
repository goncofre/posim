<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


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
        // 1. VALIDACIÓN
        try {
            $request->validate([
                'subtotal' => 'required|numeric|min:0',
                'iva' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'tipo_pago' => 'required|in:efectivo,debito,credito,transferencia',
                'requiere_despacho' => 'required|boolean',
                'cliente_despacho_id' => 'nullable|exists:cliente_despachos,id',
                'items' => 'required|array|min:1',
                'items.*.sku' => 'required|string|max:50',
                'items.*.nombre' => 'required|string|max:255',
                'items.*.cantidad' => 'required|integer|min:1',
                'items.*.precio_unitario' => 'required|numeric|min:0.01',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        }

        // 2. INICIAR TRANSACCIÓN (Asegura que todo se guarde o nada)
        try {
            DB::beginTransaction();

            // A. Guardar Venta Principal
            $venta = Venta::create([
                'user_id' => auth()->id(), // Asume que el usuario autenticado es el vendedor
                'subtotal' => $request->subtotal,
                'iva' => $request->iva,
                'total' => $request->total,
                'tipo_pago' => $request->tipo_pago,
                'requiere_despacho' => $request->requiere_despacho,
                'cliente_despacho_id' => $request->cliente_despacho_id,
            ]);

            // B. Preparar y Guardar Venta Items
            $itemsData = array_map(function($item) use ($venta) {
                return [
                    'venta_id' => $venta->id,
                    'sku' => $item['sku'],
                    'nombre_producto' => $item['nombre'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $request->items);

            VentaItem::insert($itemsData);

            // C. (FUTURO) Descontar stock de la tabla 'productos'

            DB::commit();

            $venta->load(['items', 'clienteDespacho']);
            $pdf = Pdf::loadView('boletas.pdf_boleta', compact('venta'));

            return $pdf->download('boleta-' . $venta->id . '.pdf');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error interno al guardar la transacción.'], 500);
        }
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
