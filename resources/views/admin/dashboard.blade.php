@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="display-4 mb-0">{{ $stats['orders'] }}</h2>
                            <div>Pesanan</div>
                        </div>
                        <i class="fas fa-shopping-cart fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.orders.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="display-4 mb-0">{{ $stats['products']['total'] }}</h2>
                            <div>Produk</div>
                        </div>
                        <i class="fas fa-bicycle fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.products.bikes') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="display-4 mb-0">{{ $stats['users'] }}</h2>
                            <div>Pengguna</div>
                        </div>
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.users.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="display-4 mb-0">{{ $stats['events'] }}</h2>
                            <div>Event</div>
                        </div>
                        <i class="fas fa-calendar-alt fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.events.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-shopping-bag me-1"></i>
                    Pesanan Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_orders'] as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->status == 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($order->status == 'processing')
                                                <span class="badge bg-info">Diproses</span>
                                            @elseif($order->status == 'shipped')
                                                <span class="badge bg-primary">Dikirim</span>
                                            @elseif($order->status == 'delivered')
                                                <span class="badge bg-success">Terkirim</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua Pesanan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Ringkasan Produk
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between border-bottom mb-3 pb-2">
                        <div>Sepeda</div>
                        <div class="fw-bold">{{ $stats['products']['bikes'] }}</div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom mb-3 pb-2">
                        <div>Perlengkapan</div>
                        <div class="fw-bold">{{ $stats['products']['gear'] }}</div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom mb-3 pb-2">
                        <div>Berita</div>
                        <div class="fw-bold">{{ $stats['news'] }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Event</div>
                        <div class="fw-bold">{{ $stats['events'] }}</div>
                    </div>
                </div>
                <div class="card-footer text-center d-flex justify-content-between">
                    <a href="{{ route('admin.products.bikes') }}" class="btn btn-primary btn-sm">
                        Kelola Sepeda
                    </a>
                    <a href="{{ route('admin.products.gear') }}" class="btn btn-secondary btn-sm">
                        Kelola Perlengkapan
                    </a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bullhorn me-1"></i>
                    Menu Cepat
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.products.bikes.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-bicycle me-2"></i> Tambah Sepeda Baru</div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.products.gear.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-tools me-2"></i> Tambah Perlengkapan Baru</div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.news.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-newspaper me-2"></i> Tambah Berita Baru</div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.events.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-calendar-plus me-2"></i> Tambah Event Baru</div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 