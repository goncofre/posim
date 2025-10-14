<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opcional: Deshabilitar la protección de asignación masiva si es necesario
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        // Producto::truncate(); // Limpiar la tabla si quieres que se ejecute varias veces
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $productos = [
            [
                'sku' => 'LAPTOP001',
                'nombre_producto' => 'Laptop Gamer Pro-X',
                'categoria_id' => 1, // Asume que la categoría con ID 1 ya existe
                'tipo_producto' => 'unitario',
                'precio_venta' => 1250.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'SSD512',
                'nombre_producto' => 'Disco SSD 512GB NVMe',
                'categoria_id' => 1,
                'tipo_producto' => 'unitario',
                'precio_venta' => 79.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'CAFEKG',
                'nombre_producto' => 'Café Tostado Premium (por Kg)',
                'categoria_id' => 2, // Asume que la categoría con ID 2 ya existe
                'tipo_producto' => 'granel',
                'precio_venta' => 15.00, // Precio por kilogramo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'AZUCARLB',
                'nombre_producto' => 'Azúcar Blanca (por libra)',
                'categoria_id' => 2,
                'tipo_producto' => 'granel',
                'precio_venta' => 1.25, // Precio por libra/unidad de medida
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insertar los productos en la base de datos
        Producto::insert($productos);
    }
}