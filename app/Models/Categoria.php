<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'estado',
    ];

    /**
     * Obtiene los productos que pertenecen a esta categoría.
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}