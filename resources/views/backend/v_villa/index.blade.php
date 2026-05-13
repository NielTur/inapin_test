@extends('backend.v_layouts.app')

@section('title', 'Data Villa - Admin')
@section('page-title', 'Data Villa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Data Villa</h5>
</div>

{{-- Tab Status --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('admin.villa.index') }}"
        class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-secondary' }}">
        Semua
    </a>
    <a href="{{ route('admin.villa.index', ['status' => 'pending']) }}"
        class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
        Menunggu Review
        @if($countPending > 0)
            <span class="badge bg-danger ms-1">{{ $countPending }}</span>
        @endif
    </a>
    <a href="{{ route('admin.villa.index', ['status' => 'disetujui']) }}"
        class="btn btn-sm {{ request('status') == 'disetujui' ? 'btn-success' : 'btn-outline-success' }}">
        Disetujui <span class="badge bg-white text-success ms-1">{{ $countDisetujui }}</span>
    </a>
    <a href="{{ route('admin.villa.index', ['status' => 'ditolak']) }}"
        class="btn btn-sm {{ request('status') == 'ditolak' ? 'btn-danger' : 'btn-outline-danger' }}">
        Ditolak <span class="badge bg-white text-danger ms-1">{{ $countDitolak }}</span>
    </a>
    <a href="{{ route('admin.villa.index', ['status' => 'nonaktif']) }}"
        class="btn btn-sm {{ request('status') == 'nonaktif' ? 'btn-secondary' : 'btn-outline-secondary' }}">
        Nonaktif <span class="badge bg-white text-secondary ms-1">{{ $countNonaktif }}</span>
    </a>
</div>

{{-- Tabel --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Villa</th>
                    <th>Owner</th>
                    <th>Kota</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($villas as $villa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $villa->nama_villa }}</td>
                    <td>{{ $villa->owner->nama ?? '-' }}</td>
                    <td>{{ $villa->kota }}</td>
                    <td>Rp {{ number_format($villa->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($villa->status == 'pending')
                            <span class="badge bg-warning text-dark">Menunggu Review</span>
                        @elseif($villa->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($villa->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.villa.show', $villa->id_villa) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Tidak ada data villa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {{ $villas->links() }}
</div>

@endsection