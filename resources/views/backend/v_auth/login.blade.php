<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login Admin - VillaKu</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #1a936f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Heebo', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .12);
        }

        .form-control:focus {
            border-color: #1a936f;
            box-shadow: 0 0 0 .2rem rgba(26, 147, 111, .15);
        }

        .btn-primary {
            border-radius: 8px;
            padding: .75rem;
            font-weight: 600;
        }

        .badge-admin {
            background: #fff3cd;
            color: #856404;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>

<body>
    <div class="login-card wow fadeInUp" data-wow-delay="0.1s">

        {{-- Logo --}}
        <div class="text-center mb-4">
            <img src="{{ asset('frontend/img/icon-deal.png') }}" alt="VillaKu" style="width:36px;" class="mb-2">
            <h5 class="fw-bold text-primary mb-1">VillaKu</h5>
            <span class="badge-admin">
                <i class="fa fa-shield-alt"></i> Super Admin
            </span>
        </div>

        <h5 class="fw-bold text-center mb-1">Masuk sebagai Admin</h5>
        <p class="text-muted text-center small mb-4">Kelola villa dan pengguna platform</p>

        {{-- Alert --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fa fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="admin@admin.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="inputPassword"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password"
                        required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                        <i class="fa fa-eye" id="ikonMata"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-sign-in-alt me-2"></i> Masuk ke Panel Admin
            </button>
        </form>

        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('beranda') }}" class="text-muted small">
                <i class="fa fa-arrow-left me-1"></i> Beranda
            </a>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script>
        new WOW().init();
        function togglePassword() {
            var input = document.getElementById('inputPassword');
            var ikon = document.getElementById('ikonMata');
            if (input.type === 'password') {
                input.type = 'text';
                ikon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                ikon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>