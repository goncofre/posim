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
        Schema::create('venta_items', function (Blueprint $table) {
            $table->id();

            // Clave foránea que enlaza con la tabla 'ventas'
            $table->foreignId('venta_id')
                  ->constrained('ventas')
                  ->onDelete('cascade'); // Si la venta se elimina, sus ítems también

            // Datos del Producto (Guardamos el SKU y precio para registro histórico)
            $table->string('sku');
            $table->string('nombre_producto'); // Guardar el nombre para que no cambie si se edita el producto
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2); // Precio al que se vendió
            
            // Cálculo por item
            $table->decimal('subtotal', 10, 2); // subtotal = cantidad * precio_unitario
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_items');
    }
};
