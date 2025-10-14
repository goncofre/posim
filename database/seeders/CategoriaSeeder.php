<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Electrónica', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Alimentos/Granel', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Limpieza', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ropa', 'estado' => false, 'created_at' => now(), 'updated_at' => now()],
        ];

        Categoria::insert($categorias);
    }
}