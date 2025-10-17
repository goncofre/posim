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
        Schema::create('pack_items', function (Blueprint $table) {
            $table->id(); // id_pack_item
            
            // Clave foránea al pack principal
            $table->foreignId('pack_id')
                  ->constrained('packs')
                  ->onDelete('cascade');

            // Clave foránea al producto que contiene
            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->onDelete('restrict'); // No eliminar un producto si está en un pack

            // Campos para registro
            $table->string('sku')->nullable(); // Guardamos el SKU del producto al crear el pack
            $table->integer('cantidad'); // Cantidad de ese producto que va en el pack
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pack_items');
    }
};
