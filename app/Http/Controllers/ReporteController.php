<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Muestra la vista del reporte de Productos.
     */
    public function productos()
    {
        // Lógica para obtener datos de productos para el reporte (futuro)
        
        return view('reportes.productos');
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