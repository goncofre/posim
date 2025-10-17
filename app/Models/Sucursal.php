<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'comuna',
        'region',
        'telefono',
        'email',
        'tipo',
    ];

    /**
     * El casting para el campo tipo puede ser útil aunque usemos ENUM.
     * Aquí lo dejamos simple ya que es un ENUM.
     */
    // protected $casts = [
    //     'tipo' => 'string',
    // ];

    // Opcionalmente, puedes añadir Scopes Locales para facilitar las consultas:
    
    /**
     * Scope para obtener solo las sucursales (puntos de venta).
     */
    public function scopeSucursales($query)
    {
        return $query->where('tipo', 'sucursal');
    }

    /**
     * Scope para obtener solo las bodegas.
     */
    public function scopeBodegas($query)
    {
        return $query->where('tipo', 'bodega');
    }
}