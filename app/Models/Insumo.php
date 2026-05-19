<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insumo extends Model
{
    protected $fillable = ['tipo', 'cantidad', 'cultivo_id', 'fecha_ingreso', 'observaciones'];
    protected $casts = ['fecha_ingreso' => 'date'];

    // Relación: Un insumo puede estar asociado a un tipo de cultivo específico
    public function cultivo(): BelongsTo {
        return $this->belongsTo(Cultivo::class);
    }
}
