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
        Schema::table('ventas', function (Blueprint $table) {
            // --- MODIFICACIONES ---
            
            // 1. Modificar 'total' a decimal(10, 2)
            $table->decimal('total', 10, 2)->change();
            
            // 2. Eliminar columnas que ya no usaremos
            $table->dropColumn('estado');
            $table->dropColumn('observaciones');
            
            // --- NUEVAS COLUMNAS (Añadir después de las modificaciones) ---

            // 3. Datos financieros
            $table->decimal('subtotal', 10, 2)->after('user_id'); // Colocamos después de user_id
            $table->decimal('iva', 10, 2)->after('subtotal');

            // 4. Relación con el cliente de despacho
            $table->foreignId('cliente_despacho_id')
                  ->nullable()
                  ->constrained('cliente_despachos')
                  ->after('total')
                  ->onDelete('set null'); 

            // 5. Opciones de la venta
            $table->enum('tipo_pago', ['efectivo', 'debito', 'credito', 'transferencia'])->after('cliente_despacho_id');
            $table->boolean('requiere_despacho')->default(false)->after('tipo_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Revertir las eliminaciones
            $table->string('estado')->default('finalizada');
            $table->text('observaciones')->nullable();

            // Revertir la modificación de 'total' a integer
            $table->integer('total')->change();

            // Eliminar las nuevas columnas
            $table->dropForeign(['cliente_despacho_id']);
            $table->dropColumn(['subtotal', 'iva', 'cliente_despacho_id', 'tipo_pago', 'requiere_despacho']);
        });
    }
};
