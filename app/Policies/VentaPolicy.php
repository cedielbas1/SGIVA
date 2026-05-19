<?php

namespace App\Policies;

use App\Models\Venta;
use App\Models\User;

class VentaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Venta $venta): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Venta $venta): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Venta $venta): bool
    {
        return $user->isSuperAdmin();
    }

    public function restore(User $user, Venta $venta): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Venta $venta): bool
    {
        return $user->isSuperAdmin();
    }
}
