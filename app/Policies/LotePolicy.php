<?php

namespace App\Policies;

use App\Models\Lote;
use App\Models\User;

class LotePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Lote $lote): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Lote $lote): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Lote $lote): bool
    {
        return $user->isSuperAdmin();
    }

    public function restore(User $user, Lote $lote): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Lote $lote): bool
    {
        return $user->isSuperAdmin();
    }
}
