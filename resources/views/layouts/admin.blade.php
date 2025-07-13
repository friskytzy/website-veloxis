<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Admin Panel Veloxis" />
    <title>@yield('title', 'Admin Panel') - Veloxis</title>
    
    <!-- Bootstrap & Admin CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    
    <!-- Custom Admin CSS -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --sidebar-width: 225px;
        }
        
        body {
            margin-top: 56px;
        }
        
        .sb-sidenav {
            background-color: #212529;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .sb-sidenav-menu {
            padding-top: 1rem;
        }
        
        .sb-sidenav-menu-heading {
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            position: relative;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .nav-link:hover, .nav-link.active {
            color: #fff;
        }
        
        .nav-link .sb-nav-link-icon {
            margin-right: 0.5rem;
        }
        
        .sb-sidenav-footer {
            padding: 0.75rem;
            background-color: #343a40;
        }
        
        #layoutSidenav {
            display: flex;
        }
        
        #layoutSidenav_nav {
            flex-basis: var(--sidebar-width);
            flex-shrink: 0;
            transition: transform 0.15s ease-in-out;
            z-index: 1038;
            transform: translateX(0);
        }
        
        #layoutSidenav_content {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            flex-grow: 1;
            min-height: calc(100vh - 56px);
            margin-left: var(--sidebar-width);
        }
        
        @media (max-width: 991.98px) {
            #layoutSidenav_nav {
                transform: translateX(calc(var(--sidebar-width) * -1));
            }
            
            .sb-sidenav-toggled #layoutSidenav_nav {
                transform: translateX(0);
            }
            
            #layoutSidenav_content {
                margin-left: 0;
            }
            
            .sb-sidenav-toggled #layoutSidenav_content:before {
                content: "";
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: #000;
                z-index: 1037;
                opacity: 0.5;
                transition: opacity 0.3s ease-in-out;
            }
        }
    </style>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    
    @stack('styles')
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark fixed-top">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">Veloxis Admin</a>
        
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Cari..." aria-label="Cari..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-globe"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Pengaturan</a></li>
                    <li><a class="dropdown-item" href="#!">Log Aktivitas</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Utama</div>
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Katalog</div>
                        <a class="nav-link collapsed {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">
                            <div class="sb-nav-link-icon"><i class="fas fa-bicycle"></i></div>
                            Produk
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.products.bikes*') ? 'active' : '' }}" href="{{ route('admin.products.bikes') }}">Sepeda</a>
                                <a class="nav-link {{ request()->routeIs('admin.products.gear*') ? 'active' : '' }}" href="{{ route('admin.products.gear') }}">Perlengkapan</a>
                            </nav>
                        </div>
                        
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                            Kategori
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Konten</div>
                        <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                            Berita
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                            Event
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Penjualan</div>
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Pesanan
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Pengguna</div>
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Pengguna
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai:</div>
                    {{ auth()->user()->name }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Veloxis {{ date('Y') }}</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Bootstrap & jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Admin Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    document.body.classList.toggle('sb-sidenav-toggled');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 