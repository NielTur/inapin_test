@extends('frontend.v_layouts.app')

@section('title', 'Detail Transaksi #' . $pemesanan->id_pemesanan . ' - VillaKu')

@section('content')

{{-- PAGE HEADER --}}
<div class="container-fluid bg-light py-4 mb-5">
    <div class="container">
        <h4 class="fw-bold mb-1">Detail Transaksi</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:13px;">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('booking.riwayat') }}">Riwayat Pemesanan</a></li>
                <li class="breadcrumb-item active">Detail Transaksi</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4 justify-content-center">

        {{-- ══ KIRI: Ringkasan Pemesanan ══════════════════════ --}}
        <div class="col-lg-7">

            {{-- Status Banner --}}
            @php
            $statusConfig = [
            'menunggu' => ['bg' => '#fff8e1', 'color' => '#f59e0b', 'icon' => 'fa-clock', 'label' => 'Menunggu Konfirmasi'],
            'dikonfirmasi' => ['bg' => '#ecfdf5', 'color' => '#10b981', 'icon' => 'fa-check-circle', 'label' => 'Dikonfirmasi'],
            'ditolak' => ['bg' => '#fef2f2', 'color' => '#ef4444', 'icon' => 'fa-times-circle', 'label' => 'Ditolak'],
            'selesai' => ['bg' => '#eff6ff', 'color' => '#3b82f6', 'icon' => 'fa-flag', 'label' => 'Selesai'],
            'dibatalkan' => ['bg' => '#f9fafb', 'color' => '#6b7280', 'icon' => 'fa-ban', 'label' => 'Dibatalkan'],
            ];
            $sc = $statusConfig[$pemesanan->status] ?? $statusConfig['menunggu'];
            @endphp
            <div class="rounded-4 p-4 mb-4 d-flex align-items-center gap-3"
                style="background:{{ $sc['bg'] }}; border:1px solid {{ $sc['color'] }}30;">
                <i class="fa {{ $sc['icon'] }} fa-2x" style="color:{{ $sc['color'] }};"></i>
                <div>
                    <div class="fw-bold" style="color:{{ $sc['color'] }}; font-size:16px;">{{ $sc['label'] }}</div>
                    <div class="text-muted small">
                        Pesanan diterima pada {{ $pemesanan->tanggal_pemesanan->format('d M Y, H:i') }} WIB
                    </div>
                </div>
            </div>

            {{-- Info Pemesanan --}}
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4" style="border:1px solid #f0f0f0;">
                <h6 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <span class="rounded-3 d-flex align-items-center justify-content-center"
                        style="background:#edf7f3; color:var(--primary); width:30px; height:30px;">
                        <i class="fa fa-receipt" style="font-size:12px;"></i>
                    </span>
                    Ringkasan Pemesanan
                </h6>

                {{-- Villa --}}
                <div class="d-flex gap-3 mb-4 pb-4" style="border-bottom:1px solid #f4f4f4;">
                    @php
                    $foto = $pemesanan->villa->dokumenVilla?->where('status','disetujui')->first()?->file_path;
                    @endphp
                    <img src="{{ $foto ? asset('storage/'.$foto) : asset('frontend/img/property-1.jpg') }}"
                        class="rounded-3 flex-shrink-0"
                        style="width:80px; height:65px; object-fit:cover;">
                    <div>
                        <div class="fw-semibold" style="font-size:15px;">{{ $pemesanan->villa->nama_villa }}</div>
                        <div class="text-muted small">
                            <i class="fa fa-map-marker-alt me-1 text-primary" style="font-size:10px;"></i>
                            {{ $pemesanan->villa->kota }}
                        </div>
                        <div class="text-muted small mt-1">
                            {{ Str::limit($pemesanan->villa->alamat, 50) }}
                        </div>
                    </div>
                </div>

                {{-- Detail baris-baris --}}
                @php $detail = $pemesanan->detailPemesanan; @endphp
                <div class="row g-3" style="font-size:14px;">
                    <div class="col-6">
                        <div class="text-muted small mb-1">No. Pemesanan</div>
                        <div class="fw-semibold">#{{ str_pad($pemesanan->id_pemesanan, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small mb-1">Metode Pembayaran</div>
                        <div class="fw-semibold">{{ $pemesanan->metode_pembayaran }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small mb-1">Check-in</div>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($detail->tanggal_checkin)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small mb-1">Check-out</div>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($detail->tanggal_checkout)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small mb-1">Durasi</div>
                        @php
                        $malam = \Carbon\Carbon::parse($detail->tanggal_checkin)
                        ->diffInDays($detail->tanggal_checkout);
                        @endphp
                        <div class="fw-semibold">{{ $malam }} Malam</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small mb-1">Harga per Malam</div>
                        <div class="fw-semibold">Rp {{ number_format($detail->harga_default, 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Total --}}
                <div class="mt-4 pt-3 d-flex justify-content-between align-items-center"
                    style="border-top:2px dashed #e9ecef;">
                    <span class="fw-semibold">Total Pembayaran</span>
                    <span class="fw-bold text-primary" style="font-size:20px;">
                        Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex gap-2">
                <a href="{{ route('booking.riwayat') }}"
                    class="btn btn-primary px-4 rounded-3">
                    <i class="fa fa-list me-2"></i> Lihat Riwayat Pemesanan
                </a>
                <a href="{{ route('beranda') }}"
                    class="btn btn-outline-secondary px-4 rounded-3">
                    <i class="fa fa-home me-2"></i> Kembali ke Beranda
                </a>
            </div>

        </div>

        {{-- ══ KANAN: Info Pembayaran ═════════════════════════ --}}
        <div class="col-lg-5">
            <div class="bg-white rounded-4 shadow-sm p-4 sticky-top" style="border:1px solid #f0f0f0; top:80px;">

                <h6 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <span class="rounded-3 d-flex align-items-center justify-content-center"
                        style="background:#edf7f3; color:var(--primary); width:30px; height:30px;">
                        <i class="fa fa-credit-card" style="font-size:12px;"></i>
                    </span>
                    Instruksi Pembayaran
                </h6>
                <p class="text-muted small mb-4">
                    Selesaikan pembayaran sebelum <strong>24 jam</strong> agar pesanan tidak dibatalkan otomatis.
                </p>

                {{-- Total tagihan --}}
                <div class="rounded-3 p-3 mb-4 text-center"
                    style="background:linear-gradient(135deg,#005f73,#0a9396);">
                    <div class="text-white small mb-1">Total yang harus dibayar</div>
                    <div class="text-white fw-bold" style="font-size:22px;">
                        Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                    </div>
                    <div class="text-white small opacity-75">
                        No. Pesanan: #{{ str_pad($pemesanan->id_pemesanan, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                {{-- Tabs Metode --}}
                <ul class="nav nav-pills mb-3 gap-1" id="paymentTab" role="tablist"
                    style="font-size:12px;">
                    <li class="nav-item">
                        <button class="nav-link active px-3 py-2 rounded-3" data-bs-toggle="pill"
                            data-bs-target="#tabTransfer">
                            <i class="fa fa-university me-1"></i> Transfer
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 py-2 rounded-3" data-bs-toggle="pill"
                            data-bs-target="#tabQris">
                            <i class="fa fa-qrcode me-1"></i> QRIS
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link px-3 py-2 rounded-3" data-bs-toggle="pill"
                            data-bs-target="#tabVa">
                            <i class="fa fa-mobile-alt me-1"></i> Virtual Account
                        </button>
                    </li>
                </ul>

                <div class="tab-content">

                    {{-- ── Tab Transfer Bank ── --}}
                    <div class="tab-pane fade show active" id="tabTransfer">
                        @foreach([
                        ['bank' => 'BCA', 'no' => '1234567890', 'atas' => 'VillaKu Indonesia', 'color' => '#0066AE'],
                        ['bank' => 'Mandiri', 'no' => '9876543210', 'atas' => 'PT VillaKu Nusantara', 'color' => '#003D8F'],
                        ['bank' => 'BNI', 'no' => '1122334455', 'atas' => 'VillaKu Indonesia', 'color' => '#F37021'],
                        ] as $bank)
                        <div class="rounded-3 p-3 mb-2" style="background:#f8f9fa; border:1px solid #e9ecef;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold" style="color:{{ $bank['color'] }}; font-size:13px;">
                                    Bank {{ $bank['bank'] }}
                                </span>
                                <button class="btn btn-outline-secondary btn-sm rounded-2"
                                    style="font-size:11px;"
                                    onclick="salinTeks('{{ $bank['no'] }}', this)">
                                    <i class="fa fa-copy me-1"></i> Salin
                                </button>
                            </div>
                            <div class="fw-bold mt-1" style="font-size:16px; letter-spacing:1px;">
                                {{ $bank['no'] }}
                            </div>
                            <div class="text-muted" style="font-size:11px;">a.n. {{ $bank['atas'] }}</div>
                        </div>
                        @endforeach
                        <div class="alert alert-warning rounded-3 mt-2 mb-0 py-2" style="font-size:11px;">
                            ⚠️ Ini adalah rekening <strong>sementara</strong> selagi integrasi Midtrans belum aktif.
                            Konfirmasi pembayaran via WhatsApp owner.
                        </div>
                    </div>

                    {{-- ── Tab QRIS ── --}}
                    <div class="tab-pane fade" id="tabQris">
                        <div class="text-center py-3">
                            {{-- Placeholder QR --}}
                            <div class="mx-auto rounded-3 d-flex align-items-center justify-content-center mb-3"
                                style="width:160px; height:160px; background:#f8f9fa; border:2px dashed #dee2e6;">
                                <div class="text-center text-muted">
                                    <i class="fa fa-qrcode fa-3x mb-2"></i>
                                    <div style="font-size:11px;">QR Code<br>Segera Hadir</div>
                                </div>
                            </div>
                            <div class="fw-semibold" style="font-size:13px;">QRIS VillaKu</div>
                            <div class="text-muted small">Scan menggunakan aplikasi pembayaran apapun</div>
                        </div>
                        <div class="alert alert-warning rounded-3 mb-0 py-2" style="font-size:11px;">
                            ⚠️ QRIS akan aktif setelah integrasi Midtrans selesai.
                        </div>
                    </div>

                    {{-- ── Tab Virtual Account ── --}}
                    <div class="tab-pane fade" id="tabVa">
                        @foreach([
                        ['bank' => 'BCA Virtual Account', 'no' => '70012' . str_pad($pemesanan->id_pemesanan, 6, '0', STR_PAD_LEFT), 'color' => '#0066AE'],
                        ['bank' => 'Mandiri Virtual Account', 'no' => '88908' . str_pad($pemesanan->id_pemesanan, 6, '0', STR_PAD_LEFT), 'color' => '#003D8F'],
                        ['bank' => 'BNI Virtual Account', 'no' => '98881' . str_pad($pemesanan->id_pemesanan, 6, '0', STR_PAD_LEFT), 'color' => '#F37021'],
                        ] as $va)
                        <div class="rounded-3 p-3 mb-2" style="background:#f8f9fa; border:1px solid #e9ecef;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold" style="color:{{ $va['color'] }}; font-size:12px;">
                                    {{ $va['bank'] }}
                                </span>
                                <button class="btn btn-outline-secondary btn-sm rounded-2"
                                    style="font-size:11px;"
                                    onclick="salinTeks('{{ $va['no'] }}', this)">
                                    <i class="fa fa-copy me-1"></i> Salin
                                </button>
                            </div>
                            <div class="fw-bold mt-1" style="font-size:16px; letter-spacing:1px;">
                                {{ $va['no'] }}
                            </div>
                        </div>
                        @endforeach
                        <div class="alert alert-warning rounded-3 mt-2 mb-0 py-2" style="font-size:11px;">
                            ⚠️ Nomor VA ini <strong>sementara</strong>. VA dinamis akan aktif setelah Midtrans terpasang.
                        </div>
                    </div>

                </div>{{-- /tab-content --}}
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function salinTeks(teks, btn) {
        navigator.clipboard.writeText(teks).then(function() {
            var original = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-check me-1"></i> Tersalin!';
            btn.classList.replace('btn-outline-secondary', 'btn-success');
            setTimeout(function() {
                btn.innerHTML = original;
                btn.classList.replace('btn-success', 'btn-outline-secondary');
            }, 2000);
        });
    }
</script>
@endpush