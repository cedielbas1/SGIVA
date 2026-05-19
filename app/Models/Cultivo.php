<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cultivo extends Model
{
    protected $fillable = ['nombre', 'estado'];

    public function lotes(): HasMany {
        return $this->hasMany(Lote::class);
    }
}

