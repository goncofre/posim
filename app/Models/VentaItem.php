<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VentaItem extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'venta_id',
        'sku',
        'nombre_producto',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    /**
     * Define la relación: Un ítem pertenece a una venta.
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }
}