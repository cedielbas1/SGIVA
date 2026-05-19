@extends('layouts.app')

@section('title', 'Dashboard - SGIVA')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard_sgiva.css') }}">
@endpush

@section('content')
    <!-- Sidebar Navigation -->
    <aside id="dashboardSidebar" class="sidebar" aria-label="Panel de navegación principal">
        <div class="sidebar-brand">
            <h3>
                <i class="bi bi-tree-fill"></i>
                <span>SGIVA</span>
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
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-title">
                <h1>Dashboard General</h1>
            </div>
            <div class="dashboard-control">
                <button id="sidebarToggle" class="btn btn-outline-primary btn-sm sidebar-toggle" aria-controls="dashboardSidebar" aria-expanded="true">
                    <i class="bi bi-layout-sidebar-inset-reverse"></i>
                    <span class="sidebar-toggle-text">Ocultar panel</span>
                </button>
            </div>
            <div class="topbar-right">
                <div class="user-profile">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div class="user-info">
                        <p class="user-name">{{ auth()->user()->name }}</p>
                        <p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>

                <!-- Botón de Salir Corregido para Laravel -->
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-card-icon success">
                    <i class="bi bi-sprout"></i>
                </div>
                <div class="stat-card-value">{{ $cultivosCount }}</div>
                <div class="stat-card-label">Cultivos registrados</div>
                <div class="stat-card-change positive">
                    <i class="bi bi-arrow-up"></i> Datos actualizados en tiempo real
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-card-icon warning">
                    <i class="bi bi-grid-3x3"></i>
                </div>
                <div class="stat-card-value">{{ $lotesCount }}</div>
                <div class="stat-card-label">Lotes activos</div>
                <div class="stat-card-change positive">
                    <i class="bi bi-arrow-up"></i> Nuevos lotes disponibles
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-card-icon info">
                    <i class="bi bi-boxes"></i>
                </div>
                <div class="stat-card-value">{{ $inventariosCount }}</div>
                <div class="stat-card-label">Elementos de inventario</div>
                <div class="stat-card-change positive">
                    <i class="bi bi-arrow-up"></i> Control de stock
                </div>
            </div>

            <div class="stat-card info">
                <div class="stat-card-icon info">
                    <i class="bi bi-lightning-fill"></i>
                </div>
                <div class="stat-card-value">{{ $actividadesCount }}</div>
                <div class="stat-card-label">Actividades registradas</div>
                <div class="stat-card-change positive">
                    <i class="bi bi-arrow-up"></i> Operaciones recientes
                </div>
            </div>

            <div class="stat-card warning">
                <div class="stat-card-icon warning">
                    <i class="bi bi-bag-fill"></i>
                </div>
                <div class="stat-card-value">{{ $insumosCount }}</div>
                <div class="stat-card-label">Insumos registrados</div>
                <div class="stat-card-change positive">
                    <i class="bi bi-arrow-up"></i> Inventario de insumos
                </div>
            </div>

            <div class="stat-card danger">
                <div class="stat-card-icon danger">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-card-value">${{ number_format($ventasTotal, 2) }}</div>
                <div class="stat-card-label">Ventas totales</div>
                <div class="stat-card-change positive">
                    <i class="bi bi-arrow-up"></i> Desde el inicio
                </div>
            </div>
        </div>

        <div class="charts-section">
            <div class="chart-card">
                <h3>Distribución de lotes por cultivo</h3>
                <div class="chart-summary-list">
                    @forelse($cultivosPorLote as $cultivo)
                        <div class="summary-item">
                            <span>{{ $cultivo->nombre }}</span>
                            <strong>{{ $cultivo->lotes_count }} lote{{ $cultivo->lotes_count === 1 ? '' : 's' }}</strong>
                        </div>
                    @empty
                        <p class="text-muted">No hay cultivos registrados todavía.</p>
                    @endforelse
                </div>
            </div>

            <div class="chart-card">
                <h3>Ventas últimos 7 días</h3>
                <div class="chart-summary-list">
                    @forelse($ventasUltimos7Dias as $ventaDia)
                        <div class="summary-item">
                            <span>{{ \Illuminate\Support\Carbon::parse($ventaDia->fecha)->format('d/m/Y') }}</span>
                            <strong>${{ number_format($ventaDia->total, 2) }}</strong>
                        </div>
                    @empty
                        <p class="text-muted">No se han registrado ventas recientemente.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="activity-section">
            <h3>Actividad reciente</h3>
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivities as $actividad)
                        <tr>
                            <td>{{ $actividad->fecha->format('d/m/Y') }}</td>
                            <td><span class="activity-badge activity">{{ $actividad->tipo_actividad }}</span></td>
                            <td>{{ $actividad->lote?->codigo ?? 'Lote no asignado' }} - {{ $actividad->observaciones ?? 'Sin descripción' }}</td>
                            <td>{{ $actividad->usuario?->name ?? 'Usuario desconocido' }}</td>
                            <td>
                                <span class="badge {{ $actividad->fecha->isFuture() ? 'bg-warning' : 'bg-success' }}">
                                    {{ $actividad->fecha->isFuture() ? 'Programada' : 'Realizada' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay actividades recientes para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="sidebarStatus" class="visually-hidden" aria-live="polite">Panel de navegación visible</div>
        </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebar = document.getElementById('dashboardSidebar');
                const toggleButton = document.getElementById('sidebarToggle');
                const sidebarStatus = document.getElementById('sidebarStatus');
                const mainContent = document.querySelector('.main-content');

                if (!sidebar || !toggleButton || !mainContent || !sidebarStatus) {
                    return;
                }

                toggleButton.addEventListener('click', function () {
                    const collapsed = sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed', collapsed);

                    toggleButton.setAttribute('aria-expanded', String(!collapsed));
                    toggleButton.querySelector('.sidebar-toggle-text').textContent = collapsed ? 'Mostrar panel' : 'Ocultar panel';
                    toggleButton.querySelector('i').className = collapsed ? 'bi bi-layout-sidebar-inset' : 'bi bi-layout-sidebar-inset-reverse';
                    sidebarStatus.textContent = collapsed ? 'Panel de navegación oculto' : 'Panel de navegación visible';
                });
            });
        </script>
    @endpush
@endsection