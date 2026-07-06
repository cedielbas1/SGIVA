<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard_sgiva.css') }}">

    <!-- Custom page styles -->
    @stack('styles')
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar" role="navigation" aria-label="Navegación principal" id="dashboardSidebar">
        <div class="sidebar-brand">
            <h3>
                <a href="{{ route('dashboard') }}" class="sidebar-brand-link">
                    <i class="bi bi-tree-fill"></i>
                    <span>SGIVA</span>
                </a>
            </h3>
        </div>

        <ul class="nav-menu">
            @can('viewAny', App\Models\Cultivo::class)
                <li class="nav-item">
                    <a href="{{ route('cultivos.index') }}" class="nav-link {{ request()->routeIs('cultivos.*') ? 'active' : '' }}">
                        <i class="bi bi-sprout"></i>
                        <span>Cultivos</span>
                    </a>
                </li>
            @endcan

            @can('viewAny', App\Models\Lote::class)
                <li class="nav-item">
                    <a href="{{ route('lotes.index') }}" class="nav-link {{ request()->routeIs('lotes.*') ? 'active' : '' }}">
                        <i class="bi bi-grid-3x3"></i>
                        <span>Lotes</span>
                    </a>
                </li>
            @endcan

            @can('viewAny', App\Models\Inventario::class)
                <li class="nav-item">
                    <a href="{{ route('inventarios.index') }}" class="nav-link {{ request()->routeIs('inventarios.*') ? 'active' : '' }}">
                        <i class="bi bi-boxes"></i>
                        <span>Inventarios</span>
                    </a>
                </li>
            @endcan

            @can('viewAny', App\Models\Actividad::class)
                <li class="nav-item">
                    <a href="{{ route('actividades.index') }}" class="nav-link {{ request()->routeIs('actividades.*') ? 'active' : '' }}">
                        <i class="bi bi-lightning-fill"></i>
                        <span>Actividades</span>
                    </a>
                </li>
            @endcan

            @can('viewAny', App\Models\Insumo::class)
                <li class="nav-item">
                    <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-fill"></i>
                        <span>Insumos</span>
                    </a>
                </li>
            @endcan

            @can('viewAny', App\Models\Venta::class)
                <li class="nav-item">
                    <a href="{{ route('ventas.index') }}" class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                        <i class="bi bi-cash-coin"></i>
                        <span>Ventas</span>
                    </a>
                </li>
            @endcan

            @if (request()->routeIs('dashboard'))
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-title">
                <h1>@yield('page_title', 'Sistema SGIVA')</h1>
            </div>
            <div class="dashboard-control">
                <button id="sidebarToggle" class="btn btn-outline-primary btn-sm sidebar-toggle" aria-controls="dashboardSidebar" aria-expanded="true" type="button">
                    <i class="bi bi-layout-sidebar-inset-reverse" aria-hidden="true"></i>
                    <span class="sidebar-toggle-text">Ocultar panel</span>
                </button>
            </div>
            <div class="topbar-right d-flex align-items-center gap-3">
                <!-- Botón de regreso al Dashboard (visible fuera del dashboard) -->
                @unless(request()->routeIs('dashboard'))
                    <a href="{{ route('dashboard') }}" class="btn btn-back-dashboard btn-sm me-2" aria-label="Volver al panel">
                        <i class="bi bi-arrow-left-circle"></i>
                        <span class="d-none d-sm-inline ms-1">Panel</span>
                    </a>
                @endunless

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button"
                        id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        <span class="d-none d-sm-inline text-start">
                            <strong>{{ Auth::user()->name }}</strong>
                            <small class="d-block text-muted">{{ ucfirst(Auth::user()->role ?? 'Usuario') }}</small>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                        <li><a class="dropdown-item" href="{{ route('account.edit') }}">Mi cuenta</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-wrapper">
            <div id="sidebarStatus" class="visually-hidden" aria-live="polite">Panel de navegación visible</div>
            @include('components.flash-alerts')
            @yield('content')
        </div>
    </main>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.flash-alert').forEach(function (alert) {
                setTimeout(function () {
                    if (typeof bootstrap !== 'undefined') {
                        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                        bsAlert.close();
                    }
                }, 8000);
            });

            const sidebar = document.getElementById('dashboardSidebar');
            const toggleButton = document.getElementById('sidebarToggle');
            const sidebarStatus = document.getElementById('sidebarStatus');
            const mainContent = document.querySelector('.main-content');

            if (sidebar && toggleButton && mainContent && sidebarStatus) {
                function updateSidebarState(collapsed) {
                    const isCollapsed = collapsed;
                    const buttonText = isCollapsed ? 'Mostrar panel' : 'Ocultar panel';
                    const iconClass = isCollapsed ? 'bi bi-layout-sidebar-inset' : 'bi bi-layout-sidebar-inset-reverse';

                    toggleButton.setAttribute('aria-expanded', String(!isCollapsed));
                    toggleButton.querySelector('.sidebar-toggle-text').textContent = buttonText;
                    toggleButton.querySelector('i').className = iconClass;
                    sidebarStatus.textContent = isCollapsed ? 'Panel de navegación oculto' : 'Panel de navegación visible';
                }

                toggleButton.addEventListener('click', function () {
                    const isMobile = window.matchMedia('(max-width: 991.98px)').matches;
                    let collapsed = false;

                    if (isMobile) {
                        const isShown = sidebar.classList.toggle('show-mobile');
                        sidebar.classList.toggle('collapsed', !isShown);
                        collapsed = !isShown;
                    } else {
                        collapsed = sidebar.classList.toggle('collapsed');
                        sidebar.classList.remove('show-mobile');
                    }

                    mainContent.classList.toggle('collapsed', collapsed);
                    updateSidebarState(collapsed);
                });
            }
        });
    </script>
</body>
</html>
