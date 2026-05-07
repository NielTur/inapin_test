@extends('owner.v_layouts.app')

@section('title', 'Login Owner - VillaKu')

@push('styles')
<style>
    body {
        background: #f0f4f8;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .login-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, .10);
        padding: 2.5rem 2.5rem;
        width: 100%;
        max-width: 420px;
    }

    .owner-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #edf7f3;
        color: var(--primary);
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .3px;
        margin-bottom: 1.25rem;
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        {{-- Logo + badge --}}
        <div class="text-center mb-4">
            <a href="{{ route('beranda') }}" class="d-inline-block mb-3">
                <span class="fw-bold fs-4" style="color:var(--primary);">
                    <i class="fa fa-home me-1"></i>VillaKu
                </span>
            </a>
            <div>
                <span class="owner-badge">
                    <i class="fa fa-user-tie" style="font-size:11px;"></i>
                    Panel Owner
                </span>
            </div>
            <h4 class="fw-bold mb-1">Masuk sebagai Owner</h4>
            <p class="text-muted small mb-0">Kelola villa dan pesanan Anda</p>
        </div>

        {{-- Alert --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('owner.login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <input type="email" name="email"
                    class="form-control rounded-3 @error('email') is-invalid @enderror"
                    placeholder="email@owner.com"
                    value="{{ old('email') }}"
                    autofocus required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="inputPassword"
                        class="form-control rounded-start-3 @error('password') is-invalid @enderror"
                        placeholder="Masukkan password" required>
                    <button class="btn btn-outline-secondary rounded-end-3" type="button"
                        onclick="togglePassword()">
                        <i class="fa fa-eye" id="ikonMata"></i>
                    </button>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                <i class="fa fa-sign-in-alt me-2"></i> Masuk ke Panel Owner
            </button>
        </form>

        <hr class="my-4">

        <div class="text-center">
            <a href="{{ route('beranda') }}" class="text-muted small text-decoration-none">
                <i class="fa fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>

        {{-- Pembatas visual supaya gak salah portal --}}
        <div class="mt-4 p-3 rounded-3 text-center" style="background:#f8f9fa; border:1px dashed #dee2e6;">
            <p class="text-muted small mb-1" style="font-size:11px;">Bukan Owner?</p>
            <a href="{{ route('login') }}" class="small text-primary text-decoration-none fw-semibold">
                Login sebagai Tamu / Customer →
            </a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
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
@endpush