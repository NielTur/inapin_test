<!DOCTYPE html>
<html dir="ltr" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/img/favicon.ico') }}">
    <title>@yield('title', 'Panel Admin - VillaKu')</title>

    <!-- CSS Backend (dari TokoOnline) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">

        <!-- ===== TOPBAR ===== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <a class="navbar-brand" href="{{ route('admin.beranda') }}">
                        <b class="logo-icon p-l-10">
                            <img src="{{ asset('frontend/img/icon-deal.png') }}" alt="VillaKu" class="light-logo" style="width:30px;">
                        </b>
                        <span class="logo-text" style="color:#fff; font-size:1.1rem; font-weight:700;">
                            VillaKu
                        </span>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent">
                        <i class="ti-more"></i>
                    </a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown">
                                <img src="{{ asset('frontend/img/icon-deal.png') }}" alt="admin"
                                    class="rounded-circle" width="31">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <div class="p-l-20 p-b-10">
                                    <p class="m-b-0 font-medium">{{ Auth::user()->nama ?? 'Admin' }}</p>
                                    <small class="text-muted">Super Admin</small>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('beranda') }}" target="_blank">
                                    <i class="ti-home m-r-5 m-l-5"></i> Lihat Website
                                </a>
                                <a class="dropdown-item" href=""
                                    onclick="event.preventDefault(); document.getElementById('keluar-admin').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- ===== SIDEBAR ===== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('admin.beranda') }}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-small-cap"><span class="hide-menu">MANAJEMEN USER</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('admin.customer.index') }}" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">Data Tamu</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('admin.owner.index') }}" aria-expanded="false">
                                <i class="mdi mdi-account-key"></i>
                                <span class="hide-menu">Data Owner</span>
                            </a>
                        </li>

                        <li class="nav-small-cap"><span class="hide-menu">PROPERTI</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('admin.villa.index') }}" aria-expanded="false">
                                <i class="mdi mdi-home-city"></i>
                                <span class="hide-menu">Data Villa</span>
                            </a>
                        </li>

                        <li class="nav-small-cap"><span class="hide-menu">TRANSAKSI</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('admin.pesanan.index') }}" aria-expanded="false">
                                <i class="mdi mdi-receipt"></i>
                                <span class="hide-menu">Semua Pesanan</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- ===== PAGE WRAPPER ===== -->
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>

            <footer class="footer text-center">
                VillaKu &copy; {{ date('Y') }} — Panel Super Admin
            </footer>
        </div>

    </div>

    <!-- Form Logout -->
    <form id="keluar-admin" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- JS -->
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('backend/dist/js/waves.js') }}"></script>
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>

    <script>
        // DataTables
        if ($('#zero_config').length) $('#zero_config').DataTable();

        // SweetAlert success
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}"
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}"
        });
        @endif

        // Konfirmasi hapus
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var nama = $(this).data("konf-delete");
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Hapus?',
                html: "Data <strong>" + nama + "</strong> tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>

    @stack('scripts')

</body>

</html>