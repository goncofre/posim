<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 💡 Crea 100 productos usando el ProductoFactory
        Producto::factory(100)->create();
        
        // Opcional: Mostrar un mensaje en la consola
        $this->command->info('Se han creado 100 productos de prueba.');
    }
}