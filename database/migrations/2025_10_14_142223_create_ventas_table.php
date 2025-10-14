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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            // Clave foránea al usuario que hizo la venta
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Datos de la venta
            $table->integer('total');
            $table->string('estado')->default('finalizada'); // pendiente, finalizada, cancelada
            $table->text('observaciones')->nullable();
            
            // Campos de fecha/hora
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
