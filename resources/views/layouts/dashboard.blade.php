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
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h3>
                <a href="{{ route('dashboard') }}" class="sidebar-brand-link">
                    <i class="bi bi-tree-fill"></i>
                    <span>SGIVA</span>
                </a>
            </h3>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('cultivos.index') }}" class="nav-link {{ request()->routeIs('cultivos.*') ? 'active' : '' }}">
                    <i class="bi bi-sprout"></i>
                    <span>Cultivos</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lotes.index') }}" class="nav-link {{ request()->routeIs('lotes.*') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3"></i>
                    <span>Lotes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('inventarios.index') }}" class="nav-link {{ request()->routeIs('inventarios.*') ? 'active' : '' }}">
                    <i class="bi bi-boxes"></i>
                    <span>Inventarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('actividades.index') }}" class="nav-link {{ request()->routeIs('actividades.*') ? 'active' : '' }}">
                    <i class="bi bi-lightning-fill"></i>
                    <span>Actividades</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-fill"></i>
                    <span>Insumos</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ventas.index') }}" class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i>
                    <span>Ventas</span>
                </a>
            </li>
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
            <div class="topbar-right">
                <div class="user-profile">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <p class="user-name">{{ Auth::user()->name }}</p>
                        <p class="user-role">{{ ucfirst(Auth::user()->role ?? 'Usuario') }}</p>
                    </div>
                </div>

                <!-- Botón de regreso al Dashboard (visible fuera del dashboard) -->
                @unless(request()->routeIs('dashboard'))
                    <a href="{{ route('dashboard') }}" class="btn btn-back-dashboard btn-sm me-2" aria-label="Volver al panel">
                        <i class="bi bi-arrow-left-circle"></i>
                        <span class="d-none d-sm-inline ms-1">Panel</span>
                    </a>
                @endunless

                <!-- Botón de Salir -->
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
