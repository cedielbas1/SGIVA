<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actividad extends Model
{
    protected $table = 'actividades';
    protected $fillable = ['user_id', 'tipo_actividad', 'lote_id', 'fecha', 'observaciones'];
    protected $casts = ['fecha' => 'date'];

    // Relación: La actividad la realiza un usuario (trabajador)
    public function usuario(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación: La actividad se realiza en un lote específico
    public function lote(): BelongsTo {
        return $this->belongsTo(Lote::class);
    }
}
