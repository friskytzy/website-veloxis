@extends('layouts.admin')

@section('title', 'Edit Sepeda')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Sepeda</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.bikes') }}">Sepeda</a></li>
        <li class="breadcrumb-item active">Edit Sepeda</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-bicycle me-1"></i>
            Informasi Sepeda
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.bikes.update', $bike) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Sepeda</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                   value="{{ old('name', $bike->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" 
                                      name="description" rows="4" required>{{ old('description', $bike->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $bike->price) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" min="0" value="{{ old('stock', $bike->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" 
                                        {{ old('category', $bike->category) == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <div class="card">
                                <div class="card-body text-center">
                                    <div id="image-preview" class="mb-3" style="max-height: 250px; overflow: hidden;">
                                        @if($bike->image)
                                            <img src="{{ asset('storage/' . $bike->image) }}" id="preview-img" class="img-fluid">
                                        @else
                                            <img src="" id="preview-img" class="img-fluid" style="display: none;">
                                        @endif
                                    </div>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-2">
                                        PNG, JPG, GIF maks 5MB (min 300x300px)
                                    </small>
                                    <small class="d-block mt-1">
                                        Biarkan kosong jika tidak ingin mengubah gambar
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <i class="fas fa-cogs me-1"></i>
                        Spesifikasi Tambahan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="specifications[engine]" class="form-label">Mesin</label>
                                <input type="text" class="form-control" 
                                       id="specifications[engine]" name="specifications[engine]" 
                                       value="{{ old('specifications.engine', $bike->specifications['engine'] ?? '') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="specifications[displacement]" class="form-label">Displacement</label>
                                <input type="text" class="form-control" 
                                       id="specifications[displacement]" name="specifications[displacement]" 
                                       value="{{ old('specifications.displacement', $bike->specifications['displacement'] ?? '') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="specifications[power]" class="form-label">Power</label>
                                <input type="text" class="form-control" 
                                       id="specifications[power]" name="specifications[power]" 
                                       value="{{ old('specifications.power', $bike->specifications['power'] ?? '') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="specifications[torque]" class="form-label">Torque</label>
                                <input type="text" class="form-control" 
                                       id="specifications[torque]" name="specifications[torque]" 
                                       value="{{ old('specifications.torque', $bike->specifications['torque'] ?? '') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="specifications[transmission]" class="form-label">Transmisi</label>
                                <input type="text" class="form-control" 
                                       id="specifications[transmission]" name="specifications[transmission]" 
                                       value="{{ old('specifications.transmission', $bike->specifications['transmission'] ?? '') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="specifications[weight]" class="form-label">Berat</label>
                                <input type="text" class="form-control" 
                                       id="specifications[weight]" name="specifications[weight]" 
                                       value="{{ old('specifications.weight', $bike->specifications['weight'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured', $bike->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Tampilkan di Halaman Utama
                            </label>
                            <small class="form-text text-muted d-block">
                                Centang untuk menampilkan sepeda ini di bagian produk unggulan
                            </small>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.products.bikes') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    #image-preview {
        border: 2px dashed #ddd;
        border-radius: 4px;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 250px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewImg = document.getElementById('preview-img');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection 