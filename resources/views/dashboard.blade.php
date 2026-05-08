<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard - SGIVA</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <!-- Dashboard CSS -->
        <link rel="stylesheet" href="{{ asset('css/dashboard_sgiva.css') }}">

        <!-- Vite (Opcional) -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h3>
                    <i class="bi bi-tree-fill"></i>
                    <span>SGIVA</span>
                </h3>
            </div>

            <ul class="nav-menu">
                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-sprout"></i>
                        <span>Cultivos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-grid-3x3"></i>
                        <span>Lotes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Inventario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-bag"></i>
                        <span>Insumos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Actividades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>Ventas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-file-earmark-pdf"></i>
                        <span>Reportes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-people"></i>
                        <span>Usuarios</span>
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
                <div class="topbar-right">
                    <div class="user-profile">
                        <div class="user-avatar">JD</div>
                        <div class="user-info">
                            <p class="user-name">Juan Díaz</p>
                            <p class="user-role">Administrador</p>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Salir
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="dashboard-grid">
                <!-- Total Plántulas -->
                <div class="stat-card">
                    <div class="stat-card-icon success">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stat-card-value">12,450</div>
                    <div class="stat-card-label">Plántulas en Inventario</div>
                    <div class="stat-card-change positive">
                        <i class="bi bi-arrow-up"></i> +5.2% este mes
                    </div>
                </div>

                <!-- Ventas del Mes -->
                <div class="stat-card warning">
                    <div class="stat-card-icon warning">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="stat-card-value">$45,230</div>
                    <div class="stat-card-label">Ventas del Mes</div>
                    <div class="stat-card-change positive">
                        <i class="bi bi-arrow-up"></i> +12.8% vs mes anterior
                    </div>
                </div>

                <!-- Actividades Pendientes -->
                <div class="stat-card info">
                    <div class="stat-card-icon info">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div class="stat-card-value">8</div>
                    <div class="stat-card-label">Actividades Pendientes</div>
                    <div class="stat-card-change negative">
                        <i class="bi bi-arrow-down"></i> -2 completadas hoy
                    </div>
                </div>

                <!-- Valoración Inventario -->
                <div class="stat-card danger">
                    <div class="stat-card-icon danger">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div class="stat-card-value">$98,500</div>
                    <div class="stat-card-label">Valoración del Inventario</div>
                    <div class="stat-card-change positive">
                        <i class="bi bi-arrow-up"></i> +8.3% vs mes anterior
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <!-- Distribución de Cultivos -->
                <div class="chart-card">
                    <h3>Distribución de Cultivos</h3>
                    <div class="chart-placeholder">
                        <span>Gráfico de Pastel - Café, Aguacate, Cacao</span>
                    </div>
                </div>

                <!-- Tendencia de Ventas -->
                <div class="chart-card">
                    <h3>Tendencia de Ventas (Últimos 30 días)</h3>
                    <div class="chart-placeholder">
                        <span>Gráfico de Líneas - Ventas Diarias</span>
                    </div>
                </div>
            </div>

            <!-- Activity Table -->
            <div class="activity-section">
                <h3>Actividad Reciente</h3>
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
                        <tr>
                            <td>15/05/2026 - 14:30</td>
                            <td><span class="activity-badge sales">Venta</span></td>
                            <td>Venta de 500 plántulas de Café - Lote A1</td>
                            <td>María García</td>
                            <td><span class="badge bg-success">Completado</span></td>
                        </tr>
                        <tr>
                            <td>15/05/2026 - 10:15</td>
                            <td><span class="activity-badge inventory">Inventario</span></td>
                            <td>Ingreso de 1000 bolsas para Aguacate</td>
                            <td>Carlos López</td>
                            <td><span class="badge bg-success">Completado</span></td>
                        </tr>
                        <tr>
                            <td>14/05/2026 - 16:45</td>
                            <td><span class="activity-badge activity">Actividad</span></td>
                            <td>Riego y mantenimiento - Lote B2 (Cacao)</td>
                            <td>Pedro Martínez</td>
                            <td><span class="badge bg-success">Completado</span></td>
                        </tr>
                        <tr>
                            <td>14/05/2026 - 09:20</td>
                            <td><span class="activity-badge sales">Venta</span></td>
                            <td>Venta de 300 plántulas de Aguacate - Lote C3</td>
                            <td>Ana Rodríguez</td>
                            <td><span class="badge bg-success">Completado</span></td>
                        </tr>
                        <tr>
                            <td>13/05/2026 - 15:00</td>
                            <td><span class="activity-badge inventory">Inventario</span></td>
                            <td>Ajuste de stock - Café (Pérdida por enfermedad)</td>
                            <td>Juan Díaz</td>
                            <td><span class="badge bg-warning">Pendiente Revisión</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Activar enlace activo en el menú
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        </script>
    </body>
</html>