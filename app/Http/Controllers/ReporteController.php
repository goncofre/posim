<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Para manejo de fechas

class ReporteController extends Controller
{
    /**
     * Muestra la vista del reporte de Productos.
     */
    public function productos(Request $request)
    {
        // 1. Definir el período de filtrado
        $mes = $request->input('mes', Carbon::now()->month);
        $anio = $request->input('anio', Carbon::now()->year);

        // Crear las fechas de inicio y fin del mes seleccionado
        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfDay();
        $fechaFin = Carbon::create($anio, $mes)->endOfMonth()->endOfDay();

        // 2. Consulta de Agregación para obtener la suma de cantidades
        $productosVendidos = DB::table('venta_items')
            // Filtrar por el rango de fechas de la venta principal
            ->join('ventas', 'venta_items.venta_id', '=', 'ventas.id')
            ->whereBetween('ventas.created_at', [$fechaInicio, $fechaFin])

            // Sumar la cantidad vendida y agrupar por producto (SKU y Nombre)
            ->select('venta_items.sku', 'venta_items.nombre_producto', 
                     DB::raw('SUM(venta_items.cantidad) as total_vendido'),
                     DB::raw('SUM(venta_items.subtotal) as ingresos_generados'))
            ->groupBy('venta_items.sku', 'venta_items.nombre_producto')
            ->orderByDesc('total_vendido')
            ->get();
            
        // 3. Obtener los 10 Primeros para el Gráfico
        $topDiezProductos = $productosVendidos->take(10);
        
        // 4. Formatear datos para el gráfico (separar etiquetas y valores)
        $chartData = [
            'labels' => $topDiezProductos->pluck('nombre_producto')->toArray(),
            'data' => $topDiezProductos->pluck('total_vendido')->toArray(),
        ];


        // 5. Devolver la vista con los datos
        return view('reportes.productos', [
            'productosVendidos' => $productosVendidos, // Lista completa para la tabla
            'chartData' => $chartData,                 // Top 10 para el gráfico
            'mesSeleccionado' => $mes,
            'anioSeleccionado' => $anio,
        ]);
    }

    /**
     * Muestra la vista del reporte de Usuarios.
     */
    public function usuarios()
    {
        // Lógica para obtener datos de usuarios para el reporte (futuro)
        
        return view('reportes.usuarios');
    }
}