@extends('backend.v_layouts.app')
@section('title', 'Data Tamu - Admin')
@section('page-title', 'Data Tamu')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Data Tamu</h5>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.customer.index') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama, email, atau nomor HP..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('admin.customer.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                    <th>Tgl Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $i => $c)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $c->nama }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone ?? '-' }}</td>
                    <td>{{ $c->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ route('admin.customer.destroy', $c->id_customer) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus akun {{ $c->nama }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Tidak ada data tamu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $customers->links() }}</div>

@endsection