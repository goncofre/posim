<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pack extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'nombre_pack',
        'precio_venta',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación: Un pack tiene muchos items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PackItem::class);
    }
}