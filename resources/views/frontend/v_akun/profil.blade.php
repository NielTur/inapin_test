@extends('frontend.v_layouts.app')

@section('title', 'Profil Saya - VillaKu')

@section('content')

{{-- PAGE HEADER --}}
<div class="container-fluid bg-light py-4 mb-5">
    <div class="container">
        <h1 class="fw-bold mb-2">Profil Saya</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item text-body active">Profil</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl pb-5">
    <div class="container">
        <div class="row g-5">

            {{-- ===== KIRI: Sidebar Profil ===== --}}
            <div class="col-lg-3">
                <div class="bg-light rounded p-4 text-center wow fadeInUp" data-wow-delay="0.1s">

                    {{-- Avatar + Preview --}}
                    <div class="mb-3">
                        <div class="mb-2">
                            @if($user->foto)
                            <img id="previewGambar"
                                src="{{ asset('storage/' . $user->foto) }}"
                                class="rounded-circle object-fit-cover border"
                                style="width:100px; height:100px;">
                            @else
                            <div id="previewGambar"
                                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                style="width:100px; height:100px; font-size:36px;">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            @endif
                        </div>
                        <label for="inputFoto" class="btn btn-outline-primary btn-sm" style="cursor:pointer;">
                            <i class="fa fa-camera me-1"></i> Ubah Foto
                        </label>
                    </div>

                    <h5 class="fw-bold mb-1">{{ $user->nama }}</h5>
                    <p class="text-muted small mb-4">{{ $user->email }}</p>

                    <hr>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('akun.profil') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-user me-2"></i> Profil Saya
                        </a>
                        <a href="{{ route('booking.riwayat') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-history me-2"></i> Riwayat Pemesanan
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fa fa-sign-out-alt me-2"></i> Keluar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            {{-- ===== KANAN: Form Edit Profil ===== --}}
            <div class="col-lg-9">

                @include('frontend.v_components.alert')

                <div class="bg-light rounded p-4 mb-4 wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="fw-bold mb-4">
                        <i class="fa fa-user text-primary me-2"></i> Informasi Akun
                    </h5>

                    <form action="{{ route('akun.updateProfil') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" id="inputFoto" name="foto"
                            class="d-none" accept="image/*"
                            onchange="previewFoto(this)">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $user->nama) }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control bg-white"
                                    value="{{ $user->email }}" readonly>
                                <small class="text-muted">Email tidak dapat diubah.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Handphone</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d')) }}"
                                    required>
                                @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">
                            <i class="fa fa-lock text-primary me-2"></i> Ganti Password
                            <small class="text-muted fw-normal ms-2">(opsional)</small>
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <input type="password" name="password_baru"
                                    class="form-control @error('password_baru') is-invalid @enderror"
                                    placeholder="Kosongkan jika tidak ingin ganti">
                                @error('password_baru')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_baru_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                                <i class="fa fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('previewGambar');
                if (preview.tagName === 'DIV') {
                    var img = document.createElement('img');
                    img.id = 'previewGambar';
                    img.className = 'rounded-circle object-fit-cover border';
                    img.style = 'width:100px; height:100px;';
                    preview.parentNode.replaceChild(img, preview);
                    preview = img;
                }
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>