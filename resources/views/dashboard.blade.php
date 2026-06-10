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
                    <div>
                        <span>Cultivos</span>
                        <small class="nav-desc">Registra y consulta los cultivos que siembras.</small>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lotes.index') }}" class="nav-link {{ request()->routeIs('lotes.*') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3"></i>
                    <div>
                        <span>Lotes</span>
                        <small class="nav-desc">Administra los lotes y su asignación a cultivos.</small>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('inventarios.index') }}" class="nav-link {{ request()->routeIs('inventarios.*') ? 'active' : '' }}">
                    <i class="bi bi-boxes"></i>
                    <div>
                        <span>Inventarios</span>
                        <small class="nav-desc">Controla existencias y movimientos de inventario.</small>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('actividades.index') }}" class="nav-link {{ request()->routeIs('actividades.*') ? 'active' : '' }}">
                    <i class="bi bi-lightning-fill"></i>
                    <div>
                        <span>Actividades</span>
                        <small class="nav-desc">Registra tareas y eventos agrícolas diarios.</small>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-fill"></i>
                    <div>
                        <span>Insumos</span>
                        <small class="nav-desc">Gestiona los insumos necesarios para el cultivo.</small>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ventas.index') }}" class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i>
                    <div>
                        <span>Ventas</span>
                        <small class="nav-desc">Sigue las ventas y los ingresos generados.</small>
                    </div>
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
                <button id="sidebarToggle" class="btn btn-outline-primary btn-sm sidebar-toggle" aria-controls="dashboardSidebar" aria-expanded="true" title="Mostrar u ocultar el panel de navegación">
                    <i class="bi bi-layout-sidebar-inset-reverse"></i>
                    <span class="sidebar-toggle-text">Ocultar panel</span>
                </button>
            </div>
            <div class="topbar-right">
                <button id="helpToggle" class="btn btn-outline-secondary btn-sm help-button" type="button" title="Ver guía rápida de uso">
                    <i class="bi bi-question-circle"></i> Guía
                </button>
                <div class="user-profile">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div class="user-info">
                        <p class="user-name">{{ auth()->user()->name }}</p>
                        <p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>

                <!-- Botón de Salir Corregido para Laravel -->
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm" title="Cerrar sesión segura"
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
                <p class="stat-card-description">Administra el registro y seguimiento de los cultivos en cada lote.</p>
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
                <p class="stat-card-description">Revisa los lotes disponibles y su estado de producción.</p>
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
                <p class="stat-card-description">Controla piezas, materiales y stock para el día a día.</p>
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
                <p class="stat-card-description">Monitorea tareas, eventos y acciones realizadas en los lotes.</p>
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
                <p class="stat-card-description">Gestiona insumos fundamentales para cultivos y labores agrícolas.</p>
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
                <p class="stat-card-description">Consulta el valor acumulado de ventas registradas en el sistema.</p>
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

        <div id="dashboardGuideOverlay" class="guide-overlay visually-hidden" role="dialog" aria-modal="true" aria-labelledby="dashboardGuideTitle">
            <div class="guide-card">
                <div class="guide-header">
                    <h2 id="dashboardGuideTitle">Guía rápida de SGIVA</h2>
                    <button id="guideCloseButton" class="btn-close" type="button" aria-label="Cerrar guía"></button>
                </div>
                <p>Bienvenido a SGIVA. Aquí encontrarás los módulos para gestionar cultivos, lotes, inventarios, actividades, insumos y ventas.</p>
                <ul class="guide-list">
                    <li><strong>Cultivos:</strong> Añade y consulta tus cultivos registrados.</li>
                    <li><strong>Lotes:</strong> Verifica los lotes activos y su asignación.</li>
                    <li><strong>Inventarios:</strong> Controla el stock de materiales y recursos.</li>
                    <li><strong>Actividades:</strong> Registra las labores y eventos en campo.</li>
                    <li><strong>Insumos:</strong> Gestiona los insumos para cada operación.</li>
                    <li><strong>Ventas:</strong> Consulta los ingresos y ventas totales.</li>
                </ul>
                <button id="guideGotIt" class="btn btn-primary">Entendido</button>
            </div>
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

                const helpToggle = document.getElementById('helpToggle');
                const dashboardGuide = document.getElementById('dashboardGuideOverlay');
                const guideCloseButton = document.getElementById('guideCloseButton');
                const guideGotIt = document.getElementById('guideGotIt');

                function closeGuide() {
                    dashboardGuide.classList.add('visually-hidden');
                    localStorage.setItem('sgivaDashboardGuideSeen', '1');
                }

                function openGuide() {
                    dashboardGuide.classList.remove('visually-hidden');
                }

                if (helpToggle && dashboardGuide && guideCloseButton && guideGotIt) {
                    helpToggle.addEventListener('click', openGuide);
                    guideCloseButton.addEventListener('click', closeGuide);
                    guideGotIt.addEventListener('click', closeGuide);

                    if (!localStorage.getItem('sgivaDashboardGuideSeen')) {
                        openGuide();
                    }
                }
            });
        </script>
    @endpush
@endsection