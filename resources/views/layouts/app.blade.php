<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Penilaian Prestasi') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler sidebar-toggle me-2" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Sistem Penilaian Prestasi') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Log Masuk</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Log Keluar
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        @auth
        <div class="sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                <small class="text-muted">{{ ucfirst(Auth::user()->peranan) }}</small>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                @can('admin')
                <li class="menu-header">Pentadbiran</li>
                <li>
                    <a href="{{ route('evaluation-periods.index') }}">
                        <i class="fas fa-calendar-alt"></i> Tempoh Penilaian
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-users"></i> Pengguna
                    </a>
                </li>
                @endcan
                
                <li class="menu-header">Penilaian</li>
                <li>
                    <a href="{{ route('skt.index') }}">
                        <i class="fas fa-tasks"></i> SKT
                    </a>
                </li>
                <li>
                    <a href="{{ route('evaluations.index') }}">
                        <i class="fas fa-clipboard-check"></i> Penilaian Prestasi
                    </a>
                </li>
                
                @can('admin')
                <li>
                    <a href="{{ route('reports.index') }}">
                        <i class="fas fa-file-pdf"></i> Laporan
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        @endauth

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>
</body>
</html>