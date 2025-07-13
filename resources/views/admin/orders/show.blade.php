@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Order #{{ $order->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
        <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
    </ol>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-box-open me-1"></i>
                    Order Items
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->product_name ?? 'Product #'.$item->product_id }}
                                        </td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Order Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Status:</label>
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
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">Order Date:</label>
                        <div>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">Customer:</label>
                        <div>{{ $order->user_name ?? 'Guest' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">Email:</label>
                        <div>{{ $order->user_email ?? $order->email ?? '-' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">Phone:</label>
                        <div>{{ $order->phone ?? '-' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">Shipping Address:</label>
                        <div>
                            {{ $order->address ?? '-' }}
                            @if($order->city || $order->postal_code)
                                , {{ $order->city ?? '' }} {{ $order->postal_code ?? '' }}
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold">Notes:</label>
                        <div>{{ $order->notes ?? 'None' }}</div>
                    </div>
                    
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Update Status:</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Terkirim</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 