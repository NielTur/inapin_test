<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Panel Admin - VillaKu')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <style>
        body { background: #f8f9fa; }
        #sidebar {
            width: 260px; min-height: 100vh; background: #fff;
            border-right: 1px solid #e9ecef; position: fixed;
            top: 0; left: 0; z-index: 100; transition: all .3s; overflow-y: auto;
        }
        #sidebar .sidebar-brand { padding: 1.25rem 1.5rem; border-bottom: 1px solid #e9ecef; }
        #sidebar .nav-link {
            color: #6c757d; padding: .6rem 1.5rem; border-radius: 8px;
            margin: 2px 8px; font-size: .9rem; display: flex;
            align-items: center; gap: 10px; transition: all .2s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active { background: #3bd63e5c; color: #1e7d1f; }
        #sidebar .nav-link i { width: 18px; text-align: center; }
        #sidebar .nav-section {
            font-size: 11px; text-transform: uppercase; letter-spacing: .8px;
            color: #adb5bd; padding: .75rem 1.5rem .25rem; font-weight: 600;
        }
        #main-content { margin-left: 260px; min-height: 100vh; transition: all .3s; }
        #topbar {
            background: #fff; border-bottom: 1px solid #e9ecef;
            padding: .75rem 1.5rem; position: sticky; top: 0; z-index: 99;
        }
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div id="sidebar">
        <div class="sidebar-brand d-flex align-items-center gap-2">
            <img src="{{ asset('frontend/img/icon-deal.png') }}" alt="" style="width:28px;">
            <div>
                <h6 class="mb-0 fw-bold text-danger">VillaKu</h6>
                <small class="text-muted" style="font-size:11px;">Panel Admin</small>
            </div>
        </div>

        <div class="p-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:38px; height:38px; font-size:15px;">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->nama ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="mb-0 fw-semibold text-truncate" style="font-size:13px;">
                        {{ Auth::guard('admin')->user()->nama ?? 'Admin' }}
                    </p>
                    <p class="mb-0 text-muted text-truncate" style="font-size:11px;">
                        {{ Auth::guard('admin')->user()->email ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <nav class="py-2">
            <span class="nav-section">Menu Utama</span>
            <a href="{{ route('admin.beranda') }}"
                class="nav-link {{ request()->routeIs('admin.beranda') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>

            <span class="nav-section">Manajemen Villa</span>
            @php $villaPending = \App\Models\Villa::where('status','pending')->count(); @endphp
            <a href="{{ route('admin.villa.index') }}"
                class="nav-link {{ request()->routeIs('admin.villa.*') ? 'active' : '' }}">
                <i class="fa fa-home"></i> Data Villa
                @if($villaPending > 0)
                    <span class="badge bg-danger ms-auto">{{ $villaPending }}</span>
                @endif
            </a>

            <span class="nav-section">Manajemen Pengguna</span>
            <a href="{{ route('admin.customer.index') }}"
                class="nav-link {{ request()->routeIs('admin.customer.*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> Data Tamu
            </a>
            <a href="{{ route('admin.owner.index') }}"
                class="nav-link {{ request()->routeIs('admin.owner.*') ? 'active' : '' }}">
                <i class="fa fa-user-tie"></i> Data Owner
            </a>

            <span class="nav-section">Transaksi</span>
            <a href="{{ route('admin.pesanan.index') }}"
                class="nav-link {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                <i class="fa fa-clipboard-list"></i> Semua Pesanan
            </a>

            <span class="nav-section">Akun</span>
            <a href="{{ route('beranda') }}" class="nav-link" target="_blank">
                <i class="fa fa-external-link-alt"></i> Lihat Website
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger">
                    <i class="fa fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </nav>
    </div>

    <div id="main-content">
        <div id="topbar" class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-lg-none border-0"
                    onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fa fa-bars"></i>
                </button>
                <h6 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h6>
            </div>
            <span class="text-muted small d-none d-md-inline">{{ now()->format('d M Y') }}</span>
        </div>

        @if(session('success') || session('error') || session('warning'))
        <div class="px-4 pt-3">
            @include('frontend.v_components.alert')
        </div>
        @endif

        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @stack('scripts')

</body>
</html>