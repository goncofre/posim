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
        Schema::create('sucursals', function (Blueprint $table) {
             $table->id();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('comuna')->nullable();
            $table->string('region')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            
            // Campo 'tipo' para diferenciar entre "sucursal" (punto de venta) y "bodega"
            // Esto es crucial para la lógica de documentos tributarios.
            $table->enum('tipo', ['sucursal', 'bodega']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursals');
    }
};
