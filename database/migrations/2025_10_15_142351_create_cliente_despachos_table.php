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
        Schema::create('cliente_despachos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('rut_fiscal')->unique()->nullable(); // RUT/ID Fiscal
            $table->string('direccion_despacho');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable(); // Agregamos email, útil para contacto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_despachos');
    }
};
