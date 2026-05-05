@extends('layouts.admin')

@section('title', 'Manage Spareparts')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mt-4">Sparepart Management</h1>
            <p class="text-muted mb-0">Kelola katalog sparepart database-backed untuk storefront VELOXIS.</p>
        </div>
        <a href="{{ route('admin.spareparts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Sparepart
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <input name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama, SKU, atau brand">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach(['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cogs me-1"></i>
            Spareparts
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Produk</th>
                            <th>Fitment</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spareParts as $part)
                            <tr>
                                <td><img src="{{ $part->image_url }}" alt="{{ $part->name }}" width="64" class="rounded"></td>
                                <td>
                                    <div class="fw-bold">{{ $part->name }}</div>
                                    <small class="text-muted">{{ $part->sku }} · {{ $part->category }} · {{ $part->part_brand }}</small>
                                </td>
                                <td>
                                    <div>{{ $part->motor_brand }} {{ implode(', ', array_slice($part->compatible_models ?? [], 0, 3)) }}</div>
                                    <small class="text-muted">{{ $part->compatible_years }}</small>
                                </td>
                                <td>Rp {{ number_format($part->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $part->stock <= 5 ? 'bg-danger' : 'bg-success' }}">{{ $part->stock }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $part->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($part->status) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.spareparts.edit', $part) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('veloxis.spareparts.show', $part->slug) }}" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('admin.spareparts.destroy', $part) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this sparepart?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No spareparts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $spareParts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
