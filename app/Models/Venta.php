<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'total',
        'estado',
        'observaciones',
    ];

    /**
     * Get the user that owns the Venta.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
