<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FarmaStock - @yield('titulo')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            padding: 0.75rem 1.5rem;
        }
        .navbar-brand {
            font-weight: bold;
            color: #10b981 !important;
        }
        .sidebar {
            position: fixed;
            top: 65px;
            left: 0;
            width: 250px;
            height: calc(100vh - 65px);
            background: #1e293b;
            color: white;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 8px;
        }
        .sidebar .nav-link:hover {
            background: #334155;
            color: white;
        }
        .sidebar .nav-link.active {
            background: #10b981;
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .content {
            margin-left: 250px;
            margin-top: 65px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: 0.3s;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
    @stack('estilos')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <i class="fas fa-prescription-bottle-alt me-2"></i>
                FarmaStock
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle text-dark text-decoration-none" type="button" data-bs-toggle="dropdown">
                        <img src="https://cdn-icons-png.flaticon.com/512/6326/6326055.png" class="rounded-circle" width="40" height="40">
                        <span class="ms-2">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar - control de menús por rol desde PHP -->
    <div class="sidebar">
        <div class="text-center py-4 border-bottom border-secondary">
            <i class="fas fa-prescription-bottle-alt fa-2x text-success"></i>
            <h5 class="mt-2">FarmaStock</h5>
        </div>
        <nav class="nav flex-column mt-3">
            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            
            @if(Auth::user()->rol === 'administrador' || Auth::user()->rol === 'vendedor')
            <a href="{{ url('/clientes') }}" class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Clientes
            </a>
            @endif
            
            @if(Auth::user()->rol === 'administrador')
            <a href="{{ url('/proveedores') }}" class="nav-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
                <i class="fas fa-truck"></i> Proveedores
            </a>
            @endif
            
            <a href="{{ url('/productos') }}" class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Productos
            </a>
            
            @if(Auth::user()->rol === 'administrador')
            <a href="{{ url('/compras') }}" class="nav-link {{ request()->routeIs('compras.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Compras
            </a>
            @endif
            
            @if(Auth::user()->rol === 'administrador' || Auth::user()->rol === 'vendedor')
            <a href="{{ url('/ventas') }}" class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                <i class="fas fa-cash-register"></i> Ventas
            </a>
            @endif
            
            @if(Auth::user()->rol === 'administrador')
            <a href="{{ url('/roles') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Gestionar Roles
            </a>
            @endif
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('contenido')
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Marcar menú activo por JavaScript
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            if (link.getAttribute('href') === window.location.pathname) {
                link.classList.add('active');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>