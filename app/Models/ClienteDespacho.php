<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteDespacho extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'rut_fiscal',
        'direccion_despacho',
        'telefono',
        'email',
    ];
}
