@csrf

<div class="row">
    <div class="col-md-8 mb-3">
        <label for="name" class="form-label">Nama Produk</label>
        <input id="name" name="name" value="{{ old('name', $sparePart->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="sku" class="form-label">SKU</label>
        <input id="sku" name="sku" value="{{ old('sku', $sparePart->sku) }}" class="form-control @error('sku') is-invalid @enderror" required>
        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="category" class="form-label">Kategori</label>
        <input id="category" name="category" value="{{ old('category', $sparePart->category) }}" class="form-control @error('category') is-invalid @enderror" required>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="part_brand" class="form-label">Brand Part</label>
        <input id="part_brand" name="part_brand" value="{{ old('part_brand', $sparePart->part_brand) }}" class="form-control @error('part_brand') is-invalid @enderror" required>
        @error('part_brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="motor_brand" class="form-label">Merek Motor</label>
        <input id="motor_brand" name="motor_brand" value="{{ old('motor_brand', $sparePart->motor_brand) }}" class="form-control @error('motor_brand') is-invalid @enderror" required>
        @error('motor_brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-3">
        <label for="compatible_models" class="form-label">Model Cocok</label>
        <textarea id="compatible_models" name="compatible_models" rows="3" class="form-control @error('compatible_models') is-invalid @enderror" required>{{ old('compatible_models', implode("\n", $sparePart->compatible_models ?? [])) }}</textarea>
        <div class="form-text">Pisahkan per baris atau koma. Contoh: Beat, Vario, Scoopy.</div>
        @error('compatible_models')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="compatible_years" class="form-label">Tahun Cocok</label>
        <input id="compatible_years" name="compatible_years" value="{{ old('compatible_years', $sparePart->compatible_years) }}" class="form-control @error('compatible_years') is-invalid @enderror" required>
        @error('compatible_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label for="price" class="form-label">Harga</label>
        <input id="price" name="price" type="number" min="0" value="{{ old('price', $sparePart->price) }}" class="form-control @error('price') is-invalid @enderror" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3 mb-3">
        <label for="stock" class="form-label">Stok</label>
        <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $sparePart->stock) }}" class="form-control @error('stock') is-invalid @enderror" required>
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3 mb-3">
        <label for="rating" class="form-label">Rating</label>
        <input id="rating" name="rating" type="number" min="0" max="5" step="0.1" value="{{ old('rating', $sparePart->rating ?? 4.5) }}" class="form-control @error('rating') is-invalid @enderror" required>
        @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3 mb-3">
        <label for="review_count" class="form-label">Jumlah Review</label>
        <input id="review_count" name="review_count" type="number" min="0" value="{{ old('review_count', $sparePart->review_count ?? 0) }}" class="form-control @error('review_count') is-invalid @enderror" required>
        @error('review_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label for="image_url" class="form-label">URL Gambar</label>
    <input id="image_url" name="image_url" type="url" value="{{ old('image_url', $sparePart->image_url) }}" class="form-control @error('image_url') is-invalid @enderror" required>
    @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea id="description" name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $sparePart->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="specifications" class="form-label">Spesifikasi</label>
    <textarea id="specifications" name="specifications" rows="4" class="form-control @error('specifications') is-invalid @enderror">{{ old('specifications', implode("\n", $sparePart->specifications ?? [])) }}</textarea>
    @error('specifications')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="badge" class="form-label">Badge</label>
        <input id="badge" name="badge" value="{{ old('badge', $sparePart->badge ?? 'Ready Stock') }}" class="form-control @error('badge') is-invalid @enderror" required>
        @error('badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach($statuses as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $sparePart->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input id="is_featured" name="is_featured" type="checkbox" value="1" class="form-check-input" @checked(old('is_featured', $sparePart->is_featured))>
            <label for="is_featured" class="form-check-label">Featured</label>
        </div>
    </div>
</div>

<div class="d-flex gap-2">
    <button class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.spareparts.index') }}" class="btn btn-secondary">Cancel</a>
</div>
