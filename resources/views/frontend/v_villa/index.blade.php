@extends('frontend.v_layouts.app')

@section('title', 'Cari Villa - VillaKu')

@push('styles')
<style>
    .hero-wrapper {
        margin-left: calc(-50vw + 50%);
        margin-right: calc(-50vw + 50%);
        width: 100vw;
    }

    .hero-img {
        transform-origin: center center;
    }
</style>
@endpush

@push('scripts')
<script>
    var slides = document.querySelectorAll('.hero-slide');
    var dots = document.querySelectorAll('.hero-dot');
    var current = 0;
    var interval = 3000; // Mengatur interval per gambar

    function goToSlide(n) {
        slides[current].style.opacity = '0';
        dots[current].classList.remove('bg-white');
        dots[current].classList.add('bg-opacity-50');

        current = n;

        slides[current].style.opacity = '1';
        dots[current].classList.add('bg-white');
        dots[current].classList.remove('bg-opacity-50');
    }

    function nextSlide() {
        var next = (current + 1) % slides.length;
        goToSlide(next);
    }

    // Auto slide
    var timer = setInterval(nextSlide, interval);

    // Pause on hover
    document.querySelector('.hero-wrapper').addEventListener('mouseenter', function() {
        clearInterval(timer);
    });
    document.querySelector('.hero-wrapper').addEventListener('mouseleave', function() {
        timer = setInterval(nextSlide, interval);
    });

    // Zoom on scroll
    window.addEventListener('scroll', function() {
        var scrollY = window.scrollY;
        var maxScroll = 400;
        var slides = document.querySelectorAll('.hero-slide');
        var scale = 1 + (scrollY / maxScroll) * 0.08;

        if (scrollY <= maxScroll) {
            slides.forEach(function(slide) {
                slide.style.backgroundSize = (100 + (scrollY / maxScroll) * 8) + '% auto';
            });
        }
    });

    var tamuValVilla = parseInt(document.getElementById('inputTamuVilla').value) || 1;
    var kamarValVilla = parseInt(document.getElementById('inputKamarVilla').value) || 1;

    function toggleGuestPickerVilla() {
        var picker = document.getElementById('guestPickerVilla');
        picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
    }

    function changeCountVilla(type, delta) {
        if (type === 'tamu') {
            tamuValVilla = Math.max(1, tamuValVilla + delta);
            document.getElementById('tamuCountVilla').textContent = tamuValVilla;
            document.getElementById('inputTamuVilla').value = tamuValVilla;
        } else {
            kamarValVilla = Math.max(1, kamarValVilla + delta);
            document.getElementById('kamarCountVilla').textContent = kamarValVilla;
            document.getElementById('inputKamarVilla').value = kamarValVilla;
        }
        document.getElementById('guestLabelVilla').textContent =
            tamuValVilla + ' Tamu, ' + kamarValVilla + ' Kamar';
    }

    document.addEventListener('click', function(e) {
        var picker = document.getElementById('guestPickerVilla');
        var wrapper = picker?.closest('.position-relative');
        if (picker && !wrapper?.contains(e.target)) {
            picker.style.display = 'none';
        }
    });
</script>
@endpush


@section('content')

{{-- ===================== HEADER (HERO) ===================== --}}
<div class="hero-wrapper position-relative overflow-hidden" style="height: 85vh;">

    {{-- Slides --}}
    @php
    $heroImages = [
    asset('frontend/img/carousel-1.jpg'),
    asset('frontend/img/carousel-2.jpg'),
    asset('frontend/img/header.jpg'),
    ];
    @endphp

    @foreach($heroImages as $i => $img)
    <div class="hero-slide position-absolute w-100 h-100"
        style="background: url('{{ $img }}') center center / cover no-repeat;
                   transition: opacity 1s ease-in-out;
                   opacity: {{ $i === 0 ? '1' : '0' }};
                   top: 0; left: 0;">
    </div>
    @endforeach

    {{-- Dot indicator --}}
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 d-flex gap-2" style="z-index:10;">
        @foreach($heroImages as $i => $img)
        <div class="hero-dot rounded-circle {{ $i === 0 ? 'bg-white' : 'bg-white bg-opacity-50' }}"
            style="width:10px; height:10px; cursor:pointer; transition:.3s;"
            onclick="goToSlide({{ $i }})">
        </div>
        @endforeach
    </div>

</div>


{{-- SEARCH BAR --}}
<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
    <div class="container">
        <form action="{{ route('villa.index') }}" method="GET">
            <div class="row g-2">

                {{-- Lokasi --}}
                <div class="col-md-3">
                    <input type="text" name="kota" class="form-control border-0 py-3"
                        placeholder="Cari kota atau nama villa..."
                        value="{{ request('kota') }}">
                </div>

                {{-- Check-in --}}
                <div class="col-md-3">
                    <input type="date" name="checkin" class="form-control border-0 py-3"
                        value="{{ request('checkin') }}">
                </div>

                {{-- Check-out --}}
                <div class="col-md-2">
                    <input type="date" name="checkout" class="form-control border-0 py-3"
                        value="{{ request('checkout') }}">
                </div>

                {{-- Tamu & Kamar (gabungan) --}}
                <div class="col-md-2 position-relative">
                    <div class="bg-white rounded px-3 py-2 h-100"
                        style="cursor:pointer; min-height:48px;"
                        onclick="toggleGuestPickerVilla()">
                        <small class="text-muted d-block" style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">Tamu & Kamar</small>
                        <div class="fw-semibold" id="guestLabelVilla" style="font-size:14px;">
                            {{ request('tamu', 1) }} Tamu, {{ request('kamar', 1) }} Kamar
                        </div>
                    </div>

                    <input type="hidden" name="tamu" id="inputTamuVilla" value="{{ request('tamu', 1) }}">
                    <input type="hidden" name="kamar" id="inputKamarVilla" value="{{ request('kamar', 1) }}">

                    {{-- Dropdown Picker --}}
                    <div id="guestPickerVilla" class="bg-white rounded shadow p-3 position-absolute"
                        style="display:none; top:110%; left:0; width:260px; z-index:999; border:1px solid #eee;">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="fw-semibold" style="font-size:14px;">Tamu</div>
                                <!-- <small class="text-muted">Dewasa</small> -->
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle"
                                    style="width:30px;height:30px;padding:0;"
                                    onclick="changeCountVilla('tamu', -1)">−</button>
                                <span id="tamuCountVilla" class="fw-bold">{{ request('tamu', 1) }}</span>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle"
                                    style="width:30px;height:30px;padding:0;"
                                    onclick="changeCountVilla('tamu', 1)">+</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="fw-semibold" style="font-size:14px;">Kamar</div>
                                <small class="text-muted">Jumlah kamar</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle"
                                    style="width:30px;height:30px;padding:0;"
                                    onclick="changeCountVilla('kamar', -1)">−</button>
                                <span id="kamarCountVilla" class="fw-bold">{{ request('kamar', 1) }}</span>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle"
                                    style="width:30px;height:30px;padding:0;"
                                    onclick="changeCountVilla('kamar', 1)">+</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm w-100"
                            onclick="toggleGuestPickerVilla()">
                            Selesai
                        </button>
                    </div>
                </div>

                {{-- Tombol Cari --}}
                <div class="col-md-2 d-flex align-items-center">
                    <button type="submit" class="btn btn-dark border-0 w-100 py-3">
                        <i class="fa fa-search me-2"></i> Cari
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


{{-- JUDUL SECTION --}}
<div class="container-xxl pt-5 pb-0">
    <div class="container">
        <h1 class="mb-1">Daftar Villa</h1>
        <p class="text-muted">{{ $villas->total() }} Villa Ditemukan</p>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">

            {{-- ============ SIDEBAR FILTER (kiri) ============ --}}
            <div class="col-lg-3">
                <form action="{{ route('villa.index') }}" method="GET" id="filterForm">

                    <div class="bg-white rounded-4 shadow-sm p-4 mb-4" style="border: 1px solid #f0f0f0;">

                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                                <span style="background:#edf7f3; color:var(--primary); width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fa fa-sliders-h" style="font-size:13px;"></i>
                                </span>
                                Filter
                            </h6>
                            @if(request()->hasAny(['harga_min','harga_max','rating','kota','fasilitas','kamar','sort']))
                            <a href="{{ route('villa.index') }}" class="text-muted small text-decoration-none" style="font-size:12px;">
                                <i class="fa fa-times me-1"></i> Reset
                            </a>
                            @endif
                        </div>

                        {{-- ===== RENTANG HARGA (Slider) ===== --}}
                        <div class="mb-4 pb-4" style="border-bottom: 1px solid #f0f0f0;">
                            <h6 class="fw-semibold mb-3" style="font-size:13px; color:#333;">Rentang Harga</h6>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-semibold text-primary" id="labelMin">
                                    Rp {{ number_format(request('harga_min', 0), 0, ',', '.') }}
                                </span>
                                <span class="small fw-semibold text-primary" id="labelMax">
                                    Rp {{ number_format(request('harga_max', 10000000), 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Slider --}}
                            <div class="mb-2">
                                <input type="range" class="form-range" id="sliderMin" min="0" max="10000000" step="100000"
                                    value="{{ request('harga_min', 0) }}"
                                    oninput="updateHarga('min', this.value)">
                                <input type="range" class="form-range" id="sliderMax" min="0" max="10000000" step="100000"
                                    value="{{ request('harga_max', 10000000) }}"
                                    oninput="updateHarga('max', this.value)">
                            </div>

                            <input type="hidden" name="harga_min" id="inputHargaMin" value="{{ request('harga_min', 0) }}">
                            <input type="hidden" name="harga_max" id="inputHargaMax" value="{{ request('harga_max', 10000000) }}">

                            <button type="submit" class="btn btn-primary btn-sm w-100 mt-1" style="border-radius:8px;">
                                Terapkan
                            </button>
                        </div>

                        {{-- ===== RATING ===== --}}
                        <div class="mb-4 pb-4" style="border-bottom: 1px solid #f0f0f0;">
                            <h6 class="fw-semibold mb-3" style="font-size:13px; color:#333;">Rating</h6>
                            @foreach([5.0 => '5.0', 4.5 => '4.5', 4.0 => '4.0', 3.5 => '3.5', 3.0 => '3.0'] as $val => $label)
                            <div class="mb-1">
                                <input class="d-none" type="radio" name="rating"
                                    id="rating{{ str_replace('.', '_', $val) }}" value="{{ $val }}"
                                    {{ request('rating') == $val ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <label class="d-flex align-items-center gap-2 py-1 px-2 rounded w-100"
                                    for="rating{{ str_replace('.', '_', $val) }}"
                                    style="cursor:pointer; background: {{ request('rating') == $val ? '#edf7f3' : 'transparent' }}; transition:.15s;">
                                    <div class="d-flex gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star {{ $i <= $val ? 'text-warning' : 'text-muted' }}" style="font-size:11px;"></i>
                                            @endfor
                                    </div>
                                    <span class="small fw-medium">{{ $label }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        {{-- ===== JUMLAH KAMAR ===== --}}
                        <div class="mb-4 pb-4" style="border-bottom: 1px solid #f0f0f0;">
                            <h6 class="fw-semibold mb-3" style="font-size:13px; color:#333;">Jumlah Kamar</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach([1, 2, 3, 4, 5] as $k)
                                <input type="radio" class="d-none" name="kamar"
                                    id="kamar{{ $k }}" value="{{ $k }}"
                                    {{ request('kamar') == $k ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <label for="kamar{{ $k }}"
                                    class="px-3 py-1 rounded-pill small fw-medium"
                                    style="cursor:pointer;
                                   border: 1.5px solid {{ request('kamar') == $k ? 'var(--primary)' : '#dee2e6' }};
                                   background: {{ request('kamar') == $k ? '#edf7f3' : '#fff' }};
                                   color: {{ request('kamar') == $k ? 'var(--primary)' : '#666' }};
                                   transition:.15s;">
                                    {{ $k }}{{ $k == 5 ? '+' : '' }} Kamar
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- ===== FASILITAS ===== --}}
                        <div class="mb-4 pb-4" style="border-bottom: 1px solid #f0f0f0;">
                            <h6 class="fw-semibold mb-3" style="font-size:13px; color:#333;">Fasilitas</h6>
                            @php
                            $fasilitasOptions = [
                            'Kolam Renang' => 'fa-swimming-pool',
                            'WiFi Gratis' => 'fa-wifi',
                            'Dapur Lengkap' => 'fa-utensils',
                            'Parkir Luas' => 'fa-parking',
                            'BBQ Area' => 'fa-fire',
                            'AC Setiap Kamar' => 'fa-snowflake',
                            'Sarapan' => 'fa-coffee',
                            'Laundry' => 'fa-tshirt',
                            ];
                            $fasilitasTerpilih = request()->has('fasilitas') ? (array) request('fasilitas') : [];
                            @endphp
                            @foreach($fasilitasOptions as $nama => $icon)
                            <div class="d-flex align-items-center justify-content-between py-2"
                                style="border-bottom: 1px solid #fafafa;">
                                <label class="d-flex align-items-center gap-2 mb-0 small w-100"
                                    for="fas_{{ Str::slug($nama) }}" style="cursor:pointer;">
                                    <i class="fas {{ $icon }} text-primary" style="width:14px; font-size:12px;"></i>
                                    {{ $nama }}
                                </label>
                                <input class="form-check-input m-0 flex-shrink-0" type="checkbox"
                                    name="fasilitas[]"
                                    id="fas_{{ Str::slug($nama) }}"
                                    value="{{ $nama }}"
                                    {{ in_array($nama, $fasilitasTerpilih) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                            </div>
                            @endforeach
                        </div>

                        {{-- ===== AREA  ===== --}}
                        <div>
                            <h6 class="fw-semibold mb-3" style="font-size:13px; color:#333;">Area</h6>
                            @php $kotaShown = 0; @endphp
                            @foreach($kotaList as $kota)
                            @php
                            $jumlahVilla = \App\Models\Villa::where('status','aktif')->where('kota',$kota)->count();
                            @endphp
                            <div class="d-flex align-items-center justify-content-between py-2 {{ $kotaShown >= 5 ? 'kota-extra' : '' }}"
                                style="border-bottom: 1px solid #fafafa; {{ $kotaShown >= 5 ? 'display:none!important;' : '' }}">
                                <label class="d-flex align-items-center gap-2 mb-0 small w-100"
                                    for="kota_{{ Str::slug($kota) }}" style="cursor:pointer; font-weight: {{ request('kota') == $kota ? '600' : '400' }};">
                                    <input class="form-check-input m-0 flex-shrink-0" type="radio"
                                        name="kota"
                                        id="kota_{{ Str::slug($kota) }}"
                                        value="{{ $kota }}"
                                        {{ request('kota') == $kota ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    {{ $kota }}
                                </label>
                                <span class="text-muted flex-shrink-0" style="font-size:11px;">({{ $jumlahVilla }})</span>
                            </div>
                            @php $kotaShown++; @endphp
                            @endforeach

                            @if($kotaList->count() > 5)
                            <button type="button" class="btn btn-link p-0 mt-2 text-primary small text-decoration-none"
                                id="btnLihatSemua" onclick="lihatSemuaKota()">
                                Lihat Semua <i class="fa fa-chevron-down ms-1" style="font-size:10px;"></i>
                            </button>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            @push('scripts')
            <script>
                function updateHarga(type, value) {
                    var min = parseInt(document.getElementById('sliderMin').value);
                    var max = parseInt(document.getElementById('sliderMax').value);

                    if (type === 'min' && min > max) {
                        min = max;
                        document.getElementById('sliderMin').value = min;
                    }
                    if (type === 'max' && max < min) {
                        max = min;
                        document.getElementById('sliderMax').value = max;
                    }

                    document.getElementById('inputHargaMin').value = min;
                    document.getElementById('inputHargaMax').value = max;
                    document.getElementById('labelMin').textContent = 'Rp ' + min.toLocaleString('id-ID');
                    document.getElementById('labelMax').textContent = 'Rp ' + max.toLocaleString('id-ID');
                }

                function lihatSemuaKota() {
                    document.querySelectorAll('.kota-extra').forEach(function(el) {
                        el.style.removeProperty('display');
                        el.style.setProperty('border-bottom', '1px solid #fafafa');
                    });
                    document.getElementById('btnLihatSemua').style.display = 'none';
                }
            </script>
            @endpush

            {{-- ============ VILLA GRID (kanan) ============ --}}
            <div class="col-lg-9">

                {{-- Header hasil pencarian --}}
                <div class="d-flex justify-content-between align-items-center mb-4 wow slideInRight" data-wow-delay="0.1s">
                    <div>
                        @if(request('kota'))
                        @endif
                    </div>
                    {{-- Sort --}}
                    <div>
                        <select class="form-select form-select-sm" style="width:auto;"
                            onchange="window.location='{{ route('villa.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})">
                            <option value="terbaru" {{ $sort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="harga_asc" {{ $sort == 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="harga_desc" {{ $sort == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="rating" {{ $sort == 'rating' ? 'selected' : '' }}>Rating Terbaik</option>
                        </select>
                    </div>
                </div>

                {{-- Grid Villa --}}
                <div class="row g-4">
                    @forelse($villas as $index => $villa)
                    <div class="col-md-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.1 }}s">
                        @include('frontend.v_components.villa-card', ['villa' => $villa])
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('frontend/img/icon-search.png') }}" alt=""
                            style="width:80px; opacity:.3;">
                        <h5 class="mt-4 text-muted">Villa tidak ditemukan</h5>
                        <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        <a href="{{ route('villa.index') }}" class="btn btn-outline-primary mt-2">
                            Reset Pencarian
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($villas->hasPages())
                <div class="mt-5 d-flex justify-content-center wow fadeInUp" data-wow-delay="0.1s">
                    {{ $villas->links() }}
                </div>
                @endif

            </div>
            {{-- end col-lg-9 --}}

        </div>
    </div>
</div>

@endsection