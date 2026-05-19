<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $fillable = ['cultivo_id', 'lote_id', 'cantidad_vendida', 'precio_unitario', 'total', 'fecha_venta'];
    protected $casts = ['fecha_venta' => 'date'];

    public function cultivo(): BelongsTo {
        return $this->belongsTo(Cultivo::class);
    }

    public function lote(): BelongsTo {
        return $this->belongsTo(Lote::class);
    }
}

