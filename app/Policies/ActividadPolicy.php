<?php

namespace App\Policies;

use App\Models\Actividad;
use App\Models\User;

class ActividadPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Actividad $actividad): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Actividad $actividad): bool
    {
        return $user->isAdmin() || $user->id === $actividad->user_id;
    }

    public function delete(User $user, Actividad $actividad): bool
    {
        return $user->isAdmin() || $user->id === $actividad->user_id;
    }

    public function restore(User $user, Actividad $actividad): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, Actividad $actividad): bool
    {
        return $user->isSuperAdmin();
    }
}
