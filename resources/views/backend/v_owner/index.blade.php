@extends('backend.v_layouts.app')
@section('title', 'Data Owner - Admin')
@section('page-title', 'Data Owner')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Data Owner</h5>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.owner.index') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama atau email..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('admin.owner.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
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
                @forelse($owners as $i => $o)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $o->nama }}</td>
                    <td>{{ $o->email }}</td>
                    <td>{{ $o->phone ?? '-' }}</td>
                    <td><span class="badge bg-primary">{{ $o->villa_count }} villa</span></td>
                    <td>{{ $o->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ route('admin.owner.destroy', $o->id_owner) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus akun {{ $o->nama }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Tidak ada data owner.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $owners->links() }}</div>

@endsection