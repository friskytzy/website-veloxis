@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Manage Bikes</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.products.bikes.create') }}" class="btn btn-primary">Add New Bike</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bikes as $bike)
                            <tr>
                                <td>{{ $bike->id }}</td>
                                <td>
                                    @if($bike->image)
                                        <img src="{{ asset('storage/' . $bike->image) }}" alt="{{ $bike->name }}" style="max-width: 50px;">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $bike->name }}</td>
                                <td>{{ $bike->category }}</td>
                                <td>Rp {{ number_format($bike->price, 0, ',', '.') }}</td>
                                <td>{{ $bike->stock }}</td>
                                <td>{{ $bike->is_featured ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.products.bikes.edit', $bike) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.products.bikes.destroy', $bike) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this bike?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No bikes found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $bikes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 