<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tools Lifecycle Hub – TRL</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- CSS utama aplikasi --}}
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<div class="app-shell">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        @php
            $roleSlug = auth()->user()?->role?->slug;
            $roleName = auth()->user()?->role?->name ?? 'User';
        @endphp

        <div class="sidebar-brand">
            <div class="icon"><i class="bi bi-wrench"></i></div>
            <div>
                <div class="fw-semibold">TRL</div>
                <small>Tools Lifecycle Hub</small>
            </div>
        </div>

        <nav class="nav-section">

            {{-- SELALU BOLEH --}}
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                <i class="bi bi-grid"></i>Dashboard
            </a>

            {{-- STAFF2 menu menjadi PENERIMAAN --}}
            @if ($roleSlug === 'staff2')
                <a class="nav-link {{ request()->is('pengendalian*') ? 'active' : '' }}" href="/pengendalian">
                    <i class="bi bi-arrow-down-circle"></i>Peminjaman
                </a>

            {{-- ROLE LAIN tetap PEMINJAMAN --}}
            @else
                <a class="nav-link {{ request()->is('borrow*') ? 'active' : '' }}" href="/borrow-requests">
                    <i class="bi bi-arrow-left-right"></i>Peminjaman
                </a>
            @endif


            <a class="nav-link {{ request()->is('scan') ? 'active' : '' }}" href="/scan">
                <i class="bi bi-qr-code-scan"></i>Scan QR/Barcode
            </a>

            <a class="nav-link {{ request()->is('damage*') ? 'active' : '' }}" href="/damage">
                <i class="bi bi-exclamation-triangle"></i>Kerusakan
            </a>

            <a class="nav-link {{ request()->is('tools*') ? 'active' : '' }}" href="/tools">
                <i class="bi bi-hammer"></i>Master Alat
            </a>

            <a class="nav-link {{ request()->is('reports*') ? 'active' : '' }}" href="/reports">
                <i class="bi bi-file-earmark-text"></i>Laporan
            </a>


            {{-- HANYA ADMIN BOLEH --}}
            @if ($roleSlug === 'admin')
                <a class="nav-link {{ request()->is('repairs*') ? 'active' : '' }}" href="/repairs">
                    <i class="bi bi-gear"></i>Perbaikan
                </a>

                <a class="nav-link {{ request()->is('admin/masters') ? 'active' : '' }}" href="/admin/masters">
                    <i class="bi bi-database"></i>Master Data
                </a>

                <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="/admin/users">
                    <i class="bi bi-people"></i>Manajemen User
                </a>
            @endif

        </nav>
        <div class="sidebar-user">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <div class="fw-semibold">{{ auth()->user()->name ?? auth()->user()->email ?? 'User' }}</div>
                    <small class="text-uppercase text-muted">{{ $roleName }}</small>
                </div>
            </div>

            <form action="/logout" method="post">
                @csrf
                <button class="btn btn-outline-light btn-sm w-100" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                </button>
            </form>
        </div>
    </aside>


    {{-- MAIN PANEL --}}
    <div class="main-panel">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-title">
                @hasSection('topbar-title')
                    @yield('topbar-title')
                @else
                    <h5>Selamat datang, {{ auth()->user()->email ?? 'admin@trl.local' }}</h5>
                    <span>Dashboard TRL</span>
                @endif
            </div>

            <div class="topbar-actions">
                <div class="search-input-group">
                    <i class="bi bi-search text-muted"></i>
                    <input class="search-input" type="text" placeholder="Cari..." aria-label="Cari">
                </div>

                <div class="notification">
                    <i class="bi bi-bell"></i>
                    <span class="badge rounded-pill">3</span>
                </div>
            </div>
        </header>


        {{-- CONTENT --}}
        <main class="content-wrapper">

            {{-- FLASH MESSAGES --}}
            @if (session('created'))
                <div class="alert alert-success">{{ session('created') }}</div>
            @endif

            @if (session('updated'))
                <div class="alert alert-info">{{ session('updated') }}</div>
            @endif

            @if (session('deleted'))
                <div class="alert alert-danger">{{ session('deleted') }}</div>
            @endif

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
