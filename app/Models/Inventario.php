<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventario extends Model
{
    protected $fillable = ['lote_id', 'fila', 'cantidad_actual', 'cantidad_inicial'];

    public function lote(): BelongsTo {
        return $this->belongsTo(Lote::class);
    }
}
