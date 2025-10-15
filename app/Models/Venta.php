<?php

namespace App\Models;

use App\Models\VentaItem; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subtotal',
        'iva',
        'total',
        'tipo_pago',
        'requiere_despacho',
        'cliente_despacho_id',
    ];

    /**
     * Get the user that owns the Venta.
     */
    /**
     * Define la relación: Una venta tiene muchos ítems (detalles).
     */
    public function items(): HasMany
    {
        return $this->hasMany(VentaItem::class);
    }

    /**
     * Define la relación: Una venta pertenece a un usuario (vendedor).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define la relación: Una venta puede tener un cliente de despacho asociado.
     */
    public function clienteDespacho(): BelongsTo
    {
        return $this->belongsTo(ClienteDespacho::class, 'cliente_despacho_id');
    }
    
    /**
     * Indica la conversión de tipos para asegurar que los booleanos funcionen correctamente.
     */
    protected $casts = [
        'requiere_despacho' => 'boolean',
    ];
}
