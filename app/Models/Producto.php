<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
        'nombre_producto',
        'categoria_id',
        'tipo_producto',
        'precio_venta',
    ];
    
    /**
     * Obtiene la categoría a la que pertenece el producto.
     */
    public function categoria(): BelongsTo
    {
        // Nota: Si no tienes el modelo Categoria, deberás crearlo.
        return $this->belongsTo(Categoria::class); 
    }
}
