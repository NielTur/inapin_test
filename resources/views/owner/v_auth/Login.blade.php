<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login Owner - VillaKu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #005f73 0%, #0a9396 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Heebo', sans-serif;
        }
        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.20);
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
        }
        .owner-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #edf7f3;
            color: var(--primary);
            border-radius: 20px;
            padding: 5px 16px;
            font-size: 12px;
            font-weight: 600;
        }
        .form-control { border-radius: 10px !important; padding: .6rem 1rem; font-size: 14px; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(10,147,150,.15); }
        .btn { border-radius: 10px !important; }
        .divider-text { position: relative; text-align: center; margin: 1.25rem 0; }
        .divider-text::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e9ecef; }
        .divider-text span { position: relative; background: #fff; padding: 0 12px; font-size: 12px; color: #adb5bd; }
    </style>
</head>
<body>

<div class="auth-card">

    <div class="text-center mb-4">
        <a href="{{ route('beranda') }}" class="text-decoration-none d-inline-block mb-3">
            <span class="fw-bold" style="font-size:22px; color:var(--primary);">
                <i class="fa fa-home me-1"></i>VillaKu
            </span>
        </a>
        <div class="mb-2">
            <span class="owner-badge">
                <i class="fa fa-user-tie" style="font-size:11px;"></i> Panel Owner
            </span>
        </div>
        <h5 class="fw-bold mb-1">Masuk sebagai Owner</h5>
        <p class="text-muted small mb-0">Kelola villa dan pesanan Anda dari sini</p>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2">
        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2">
        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('owner.login') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold small mb-1">Email</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="email@owner.com"
                   value="{{ old('email') }}" autofocus required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small mb-1">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="inputPassword"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Masukkan password" required>
                <button class="btn btn-outline-secondary" type="button"
                        onclick="togglePassword()">
                    <i class="fa fa-eye" id="ikonMata"></i>
                </button>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Ingat saya</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
            <i class="fa fa-sign-in-alt me-2"></i> Masuk ke Panel Owner
        </button>
    </form>

    <div class="divider-text"><span>Belum punya akun owner?</span></div>

    <a href="{{ route('owner.register') }}"
       class="btn btn-outline-primary w-100 fw-semibold py-2">
        <i class="fa fa-user-plus me-2"></i> Daftar sebagai Owner
    </a>

    <hr class="my-4">

    <div class="d-flex justify-content-between" style="font-size:13px;">
        <a href="{{ route('beranda') }}" class="text-muted text-decoration-none">
            <i class="fa fa-arrow-left me-1"></i> Beranda
        </a>
        <a href="{{ route('login') }}" class="text-muted text-decoration-none">
            Login sebagai Tamu →
        </a>
    </div>

</div>

<script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
<script>
    function togglePassword() {
        var input = document.getElementById('inputPassword');
        var ikon  = document.getElementById('ikonMata');
        input.type = input.type === 'password' ? 'text' : 'password';
        ikon.classList.toggle('fa-eye');
        ikon.classList.toggle('fa-eye-slash');
    }
</script>
</body>
</html>