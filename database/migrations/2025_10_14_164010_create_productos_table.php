<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('nombre_producto');
            
            // Clave foránea a la tabla de categorías
            // Nota: Asume que ya existe una tabla 'categorias'
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');
            
            // Tipo de producto, limitado a dos opciones
            $table->enum('tipo_producto', ['unitario', 'granel'])->default('unitario');
            
            $table->decimal('precio_venta', 10, 2); // Ejemplo: Precio (máximo 10 dígitos, 2 decimales)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
