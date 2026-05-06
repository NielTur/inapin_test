@extends('backend.v_layouts.app')
@section('title', 'Data Tamu - Admin VillaKu')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-0">
        <h4 class="font-medium mb-0">Data Tamu</h4>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Tamu Terdaftar</h4>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>NIK</th>
                                <th>Tgl Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $i => $c)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $c->nama }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->phone ?? '-' }}</td>
                                <td>{{ $c->nik ?? '-' }}</td>
                                <td>{{ $c->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.customer.destroy', $c->id_customer) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                            data-konf-delete="{{ $c->nama }}">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


{{-- ============================================================ --}}
{{-- FILE: resources/views/backend/v_owner/index.blade.php       --}}
{{-- ============================================================ --}}
@extends('backend.v_layouts.app')
@section('title', 'Data Owner - Admin VillaKu')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-0">
        <h4 class="font-medium mb-0">Data Owner</h4>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Owner Terdaftar</h4>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Jumlah Villa</th>
                                <th>Tgl Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($owners as $i => $o)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $o->nama }}</td>
                                <td>{{ $o->email }}</td>
                                <td>{{ $o->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $o->villa_count }} villa</span>
                                </td>
                                <td>{{ $o->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.owner.destroy', $o->id_owner) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                            data-konf-delete="{{ $o->nama }}">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


{{-- ============================================================ --}}
{{-- FILE: resources/views/backend/v_villa/index.blade.php       --}}
{{-- ============================================================ --}}
@extends('backend.v_layouts.app')
@section('title', 'Data Villa - Admin VillaKu')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-0">
        <h4 class="font-medium mb-0">Data Villa</h4>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Semua Villa</h4>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Villa</th>
                                <th>Owner</th>
                                <th>Kota</th>
                                <th>Harga/Malam</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($villas as $i => $v)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $v->nama_villa }}</td>
                                <td>{{ $v->owner->nama ?? '-' }}</td>
                                <td>{{ $v->kota }}</td>
                                <td>Rp {{ number_format($v->harga, 0, ',', '.') }}</td>
                                <td>{{ $v->kapasitas }} tamu</td>
                                <td>
                                    @if($v->status === 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                    @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Toggle Status --}}
                                        <form action="{{ route('admin.villa.status', $v->id_villa) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status"
                                                value="{{ $v->status === 'aktif' ? 'nonaktif' : 'aktif' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $v->status === 'aktif' ? 'btn-warning' : 'btn-success' }}">
                                                {{ $v->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        {{-- Hapus --}}
                                        <form action="{{ route('admin.villa.destroy', $v->id_villa) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                                data-konf-delete="{{ $v->nama_villa }}">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


{{-- ============================================================ --}}
{{-- FILE: resources/views/backend/v_pesanan/index.blade.php     --}}
{{-- ============================================================ --}}
@extends('backend.v_layouts.app')
@section('title', 'Semua Pesanan - Admin VillaKu')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-0">
        <h4 class="font-medium mb-0">Semua Pesanan</h4>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rekap Semua Transaksi</h4>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Villa</th>
                                <th>Owner</th>
                                <th>Tamu</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tgl Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $i => $p)
                            @php $detail = $p->detailPemesanan; @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $p->villa->nama_villa ?? '-' }}</td>
                                <td>{{ $p->villa->owner->nama ?? '-' }}</td>
                                <td>{{ $p->customer->nama ?? '-' }}</td>
                                <td>{{ $detail ? \Carbon\Carbon::parse($detail->tanggal_checkin)->format('d M Y') : '-' }}</td>
                                <td>{{ $detail ? \Carbon\Carbon::parse($detail->tanggal_checkout)->format('d M Y') : '-' }}</td>
                                <td>Rp {{ $detail ? number_format($detail->sub_total, 0, ',', '.') : '-' }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($p->metode_pembayaran)) }}</td>
                                <td>
                                    @php
                                    $badge = ['menunggu'=>'warning','dikonfirmasi'=>'success','ditolak'=>'danger','dibatalkan'=>'secondary','selesai'=>'info'];
                                    $status = $p->status ?? 'menunggu';
                                    @endphp
                                    <span class="badge badge-{{ $badge[$status] ?? 'secondary' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>{{ $p->tanggal_pemesanan->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection