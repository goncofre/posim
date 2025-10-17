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
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique(); // SKU único para vender el pack
            $table->string('nombre_pack');
            $table->decimal('precio_venta', 10, 2); // Precio al que se venderá el pack completo
            $table->boolean('activo')->default(true); // Para activar/desactivar el pack sin eliminarlo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packs');
    }
};
