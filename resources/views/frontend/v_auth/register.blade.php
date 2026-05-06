@extends('frontend.v_layouts.app')

@section('title', 'Daftar - VillaKu')

@section('content')

<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="bg-light rounded p-4 p-md-5 wow fadeInUp" data-wow-delay="0.1s">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Buat Akun VillaKu</h3>
                        <p class="text-muted small">Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-primary fw-semibold">Masuk di sini</a>
                        </p>
                    </div>

                    @include('frontend.v_components.alert')

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- Nama Lengkap --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Nama lengkap Anda"
                                    value="{{ old('nama') }}" required autofocus>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="contoh@email.com"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Handphone</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="08xxxxxxxxxx"
                                    value="{{ old('phone') }}" required>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="inputPassword"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Minimal 8 karakter" required>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('inputPassword', 'ikonMata1')">
                                        <i class="fa fa-eye" id="ikonMata1"></i>
                                    </button>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="inputPassword2"
                                        class="form-control"
                                        placeholder="Ulangi password" required>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('inputPassword2', 'ikonMata2')">
                                        <i class="fa fa-eye" id="ikonMata2"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Tombol Daftar --}}
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                    <i class="fa fa-user-plus me-2"></i> Buat Akun
                                </button>
                            </div>

                        </div>
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
    function togglePassword(inputId, iconId) {
        var input = document.getElementById(inputId);
        var ikon = document.getElementById(iconId);
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