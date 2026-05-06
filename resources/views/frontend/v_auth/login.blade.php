@extends('frontend.v_layouts.app')

@section('title', 'Masuk - VillaKu')

@section('content')

<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="bg-light rounded p-4 p-md-5 wow fadeInUp" data-wow-delay="0.1s">

                    {{-- Header --}}
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Masuk ke VillaKu</h3>
                        <p class="text-muted small">Belum punya akun?
                            <a href="{{ route('register') }}" class="text-primary fw-semibold">Daftar gratis</a>
                        </p>
                    </div>

                    @include('frontend.v_components.alert')

                    {{-- Form Login --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="contoh@email.com"
                                value="{{ old('email') }}"
                                required autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="inputPassword"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password"
                                    required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword()">
                                    <i class="fa fa-eye" id="ikonMata"></i>
                                </button>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Ingat saya</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="fa fa-sign-in-alt me-2"></i> Masuk
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <a href="{{ route('beranda') }}" class="text-muted small">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Beranda
                        </a>
                    </div>

                </div>
            </div>
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