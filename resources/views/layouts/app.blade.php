<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bookstoreside')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #335c67;
            --dark-color: #2a4a54;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }

        .navbar {
            background-color: white;
            border-bottom: 2px solid var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        .nav-link {
            color: var(--primary-color) !important;
            font-weight: 500;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--dark-color) !important;
        }

        .btn-login, .btn-register {
            font-weight: 600;
            border-radius: 5px;
        }

        .btn-login {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-login:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-register {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-register:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
        }

        .sidebar {
            background-color: var(--dark-color);
            min-height: calc(100vh - 120px);
            position: fixed;
            left: 0;
            top: 56px;
            width: 260px;
            overflow-y: auto;
        }

        .sidebar-nav {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin: 0;
        }

        .sidebar-nav a {
            display: block;
            padding: 12px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: var(--primary-color);
            color: white;
            border-left-color: #4a7c8f;
        }

        .sidebar-nav a i {
            width: 20px;
            margin-right: 12px;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: calc(100vh - 120px);
        }

        .main-content-full {
            margin-left: 0;
            padding: 30px;
            min-height: calc(100vh - 120px);
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 30px 0;
            margin-top: 50px;
            border-top: 2px solid var(--primary-color);
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        .page-title {
            color: var(--dark-color);
            font-weight: bold;
            margin-bottom: 30px;
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .form-control, .form-select {
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(51, 92, 103, 0.25);
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .table thead th {
            border: none;
            font-weight: 600;
        }

        .badge {
            padding: 6px 12px;
            font-weight: 500;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--dark-color);
        }

        .search-form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-form .form-control {
            border-right: none;
            font-size: 0.95rem;
        }

        .search-form .btn-search {
            border-left: none;
            background-color: white;
            border-color: #ddd;
            color: var(--primary-color);
        }

        .search-form .btn-search:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                top: 0;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .navbar-collapse {
                background-color: white;
                border-top: 1px solid var(--primary-color);
            }

            .search-form {
                max-width: 100%;
                margin-top: 10px;
            }
        }
    </style>

    @yield('extra-css')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-book"></i>
                Bookstoreside
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @unless(Route::is('login') || Route::is('register'))
                    <form action="{{ route('books.index') }}" method="GET" class="d-flex search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari judul, penulis, atau ISBN..." value="{{ request('search') }}">
                            <button class="btn btn-search" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                @endunless
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.categories.index') }}">Kategori</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">User</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}">Pesanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.messages.index') }}">Pesan</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.dashboard') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cart.index') }}">Keranjang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">Pesanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('messages.index') }}">Pesan</a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm btn-login">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm btn-register">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar untuk Admin -->
    @auth
        @if(auth()->user()->role === 'admin')
            <div class="sidebar d-none d-md-block">
                <ul class="sidebar-nav">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="{{ Route::is('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-list"></i>
                            Kategori
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="{{ Route::is('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            User
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="{{ Route::is('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-bag"></i>
                            Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.messages.index') }}" class="{{ Route::is('admin.messages.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i>
                            Pesan
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    @endauth

    <!-- Main Content -->
    @auth
        @if(auth()->user()->role === 'admin')
            <div class="main-content">
        @else
            <div class="main-content-full">
        @endif
    @else
        <div class="main-content-full">
    @endauth
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi Kesalahan!</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">
                        <i class="fas fa-book"></i> Bookstoreside
                    </h5>
                    <p class="text-muted">Toko buku online terpercaya dengan koleksi novel terbaik Indonesia.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Tautan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">Tim</a></li>
                        <li><a href="{{ route('about') }}#contact">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Hubungi Kami</h5>
                    <p class="text-muted mb-2">
                        <i class="fas fa-phone"></i> +62 821-447-158-31
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fas fa-envelope"></i> firmanfdlh1@gmail.com
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt"></i> Bali, Indonesia
                    </p>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; 2025 Firman Fadilah - Bookstoreside. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    @yield('extra-js')
</body>
</html>