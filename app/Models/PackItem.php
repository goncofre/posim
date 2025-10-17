<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pack_id',
        'producto_id',
        'sku',
        'cantidad',
    ];

    /**
     * Relación: Un ítem pertenece a un pack.
     */
    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }
    
    /**
     * Relación: Un ítem está asociado a un producto.
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}