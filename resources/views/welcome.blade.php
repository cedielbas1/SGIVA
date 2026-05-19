<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SGIVA - {{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <!-- Estilos Personalizados SGIVA -->
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

        <!-- Vite (Opcional si usas otros estilos) -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-tree-fill"></i> Semihuila
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#modulos">Módulos</a>
                        </li>
                        @if (Route::has('login'))
                            <li class="nav-item ms-lg-3">
                                <a href="{{ route('login') }}" class="btn btn-outline-success px-4 rounded-pill">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item ms-2">
                                    <a href="{{ route('register') }}" class="btn btn-primary px-4 rounded-pill">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header id="inicio" class="hero-section">
            <div class="container text-center">
                <h1 class="display-3 fw-bold mb-4">Gestión Integral para Vivero Agrícola</h1>
                <p class="lead mb-5">Optimiza la producción de café, aguacate y cacao con trazabilidad total y control financiero.</p>
                <div class="hero-buttons d-grid gap-3 d-sm-flex justify-content-sm-center">
                    @auth
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill">
                                    <i class="bi bi-person-plus me-2"></i>Registrarse
                                </a>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        <!-- Features Section -->
        <section id="modulos" class="py-5">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="section-title">Nuestros Módulos</h2>
                    <p class="section-subtitle">Herramientas diseñadas para la eficiencia operativa de tu vivero</p>
                </div>
                <div class="row g-4">
                    <!-- Inventario -->
                    <div class="col-md-4">
                        <div class="card h-100 p-4 text-center">
                            <div class="feature-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h3>Inventario Biológico</h3>
                            <p class="text-muted">Control detallado por cultivo, lote y fila. Trazabilidad completa del ciclo de vida de tus plántulas.</p>
                        </div>
                    </div>
                    <!-- Operaciones -->
                    <div class="col-md-4">
                        <div class="card h-100 p-4 text-center">
                            <div class="feature-icon">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <h3>Control Operativo</h3>
                            <p class="text-muted">Registro de actividades por trabajador e ingreso de insumos y bolsas de manera centralizada.</p>
                        </div>
                    </div>
                    <!-- Ventas -->
                    <div class="col-md-4">
                        <div class="card h-100 p-4 text-center">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <h3>Gestión de Ventas</h3>
                            <p class="text-muted">Registro de ventas, cálculo automático de ingresos y valoración económica del inventario.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Info Section -->
        <section class="info-section">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="img-fluid" alt="Vivero Agrícola">
                    </div>
                    <div class="col-lg-6 ps-lg-5">
                        <h2>¿Por qué usar SGIVA?</h2>
                        <ul>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Centralización de información productiva y financiera.</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Reportes financieros y productivos en tiempo real.</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Control de acceso basado en roles (Admin, Encargado, Ventas, Trabajador).</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Interfaz intuitiva y compatible con navegadores modernos.</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Trazabilidad completa del ciclo de vida de plántulas.</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Cálculo automático de inventario y valoración económica.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="container">
                <p class="fw-bold mb-2">SGIVA - Sistema de Gestión Integral para Vivero Agrícola</p>
                <p class="small text-muted mb-0">&copy; 2026 Todos los derechos reservados. Versión 1.0</p>
            </div>
        </footer>

        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            // Smooth scroll para los enlaces de navegación
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>
    </body>
</html>