<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        // Define categorías de ejemplo. Asume que tienes categorías con IDs válidos.
        $categorias = [1, 2, 3, 4]; 
        $tipos = ['unitario', 'granel'];

        return [
            // SKU: Genera un código SKU aleatorio (ej: PROD-98765)
            'sku' => 'PROD-' . $this->faker->unique()->randomNumber(5),
            
            // Nombre del Producto
            'nombre_producto' => $this->faker->word() . ' ' . $this->faker->colorName() . ' ' . $this->faker->randomElement(['Pro', 'Mini', 'XL', 'Pack']),
            
            // Categoría: Asigna una de las IDs de categoría definidas arriba
            'categoria_id' => $this->faker->randomElement($categorias),
            
            // Tipo de Producto: Unidad, granel o servicio
            'tipo_producto' => $this->faker->randomElement($tipos),
            
            // Precio de Venta: Número aleatorio entre 500 y 50000, con 2 decimales
            'precio_venta' => $this->faker->randomFloat(2, 500, 50000),
        ];
    }
}