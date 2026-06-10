<?php

namespace App\Providers;

use App\Models\Cultivo;
use App\Models\Lote;
use App\Models\Inventario;
use App\Models\Actividad;
use App\Models\Insumo;
use App\Models\Venta;
use App\Policies\CultivoPolicy;
use App\Policies\LotePolicy;
use App\Policies\InventarioPolicy;
use App\Policies\ActividadPolicy;
use App\Policies\InsumoPolicy;
use App\Policies\VentaPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar Policies
        Gate::policy(Cultivo::class, CultivoPolicy::class);
        Gate::policy(Lote::class, LotePolicy::class);
        Gate::policy(Inventario::class, InventarioPolicy::class);
        Gate::policy(Actividad::class, ActividadPolicy::class);
        Gate::policy(Insumo::class, InsumoPolicy::class);
        Gate::policy(Venta::class, VentaPolicy::class);

        // Permitir automáticamente todos los permisos a super_admin
        Gate::before(fn ($user, $ability) => $user->isSuperAdmin() ? true : null);

        // Gates para roles
        Gate::define('super_admin', fn ($user) => $user->isSuperAdmin());
        Gate::define('admin', fn ($user) => $user->isAdmin());
        Gate::define('user', fn ($user) => $user->isUser());
    }
}

