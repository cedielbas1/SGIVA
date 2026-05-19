<?php

namespace App\Policies;

use App\Models\Insumo;
use App\Models\User;

class InsumoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Insumo $insumo): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Insumo $insumo): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Insumo $insumo): bool
    {
        return $user->isSuperAdmin();
    }

    public function restore(User $user, Insumo $insumo): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Insumo $insumo): bool
    {
        return $user->isSuperAdmin();
    }
}
