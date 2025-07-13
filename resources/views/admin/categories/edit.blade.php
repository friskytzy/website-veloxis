@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Category</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Category
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="">Select type...</option>
                        <option value="bike" {{ old('type', $category->type) == 'bike' ? 'selected' : '' }}>Bike</option>
                        <option value="gear" {{ old('type', $category->type) == 'gear' ? 'selected' : '' }}>Gear</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Category (Optional)</label>
                    <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                        <option value="">None (Top Level Category)</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->name }} ({{ ucfirst($parentCategory->type) }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
    
    @if($category->products()->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cube me-1"></i>
            Associated Products
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <p>This category has {{ $category->products()->count() }} associated products. Changing the category type might cause issues with product associations.</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->products()->limit(5)->get() as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ ucfirst($category->type) }}</td>
                                <td>
                                    @if($category->type === 'bike')
                                    <a href="{{ route('admin.products.bikes.edit', $product) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @else
                                    <a href="{{ route('admin.products.gear.edit', $product) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if($category->products()->count() > 5)
                            <tr>
                                <td colspan="3" class="text-center">
                                    <em>Showing 5 of {{ $category->products()->count() }} products</em>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Filter parent categories based on selected type
    $(document).ready(function() {
        $('#type').change(function() {
            const selectedType = $(this).val();
            
            $('#parent_id option').each(function() {
                const optionText = $(this).text();
                
                // Skip the default "None" option
                if ($(this).val() === '') return;
                
                // Show only matching type categories
                if (selectedType && !optionText.includes(selectedType.charAt(0).toUpperCase() + selectedType.slice(1))) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            // Reset selection if hidden option was selected
            const currentSelection = $('#parent_id').val();
            if (currentSelection) {
                const selectedOptionVisible = $('#parent_id option[value="' + currentSelection + '"]:visible').length > 0;
                if (!selectedOptionVisible) {
                    $('#parent_id').val('');
                }
            }
        });
        
        // Trigger on page load
        $('#type').trigger('change');
    });
</script>
@endpush 