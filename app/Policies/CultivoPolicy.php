<?php

namespace App\Policies;

use App\Models\Cultivo;
use App\Models\User;

class CultivoPolicy
{
    /**
     * Determinar si el usuario puede ver cualquier cultivo
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos los autenticados pueden ver
    }

    /**
     * Determinar si el usuario puede ver este cultivo
     */
    public function view(User $user, Cultivo $cultivo): bool
    {
        return true; // Todos los autenticados pueden ver
    }

    /**
     * Determinar si el usuario puede crear cultivos
     */
    public function create(User $user): bool
    {
        return $user->isAdmin(); // Solo admin y super_admin pueden crear cultivos
    }

    /**
     * Determinar si el usuario puede actualizar este cultivo
     */
    public function update(User $user, Cultivo $cultivo): bool
    {
        return $user->isAdmin(); // Solo admin y super_admin pueden actualizar cultivos
    }

    /**
     * Determinar si el usuario puede eliminar este cultivo
     */
    public function delete(User $user, Cultivo $cultivo): bool
    {
        return $user->isSuperAdmin(); // Solo super admin
    }

    /**
     * Determinar si el usuario puede restaurar este cultivo
     */
    public function restore(User $user, Cultivo $cultivo): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determinar si el usuario puede forzar eliminar este cultivo
     */
    public function forceDelete(User $user, Cultivo $cultivo): bool
    {
        return $user->isSuperAdmin();
    }
}
