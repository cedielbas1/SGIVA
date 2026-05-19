<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lote extends Model
{
    protected $fillable = ['codigo', 'cultivo_id', 'cantidad_filas', 'estado'];

    public function cultivo(): BelongsTo {
        return $this->belongsTo(Cultivo::class);
    }

    public function inventarios(): HasMany {
        return $this->hasMany(Inventario::class);
    }
}

