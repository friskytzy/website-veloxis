<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GearStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'price' => ['required', 'numeric', 'min:100000', 'max:100000000'],
            'category' => ['required', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000'],
            'size' => ['sometimes', 'string', 'max:50'],
            'color' => ['sometimes', 'string', 'max:50'],
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // 5MB max
                'dimensions:min_width=300,min_height=300,max_width=4000,max_height=4000'
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama gear wajib diisi.',
            'name.min' => 'Nama gear minimal 3 karakter.',
            'name.max' => 'Nama gear maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
            'description.max' => 'Deskripsi maksimal 2000 karakter.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal Rp 100.000.',
            'price.max' => 'Harga maksimal Rp 100.000.000.',
            'category.required' => 'Kategori wajib diisi.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok minimal 0.',
            'stock.max' => 'Stok maksimal 1000.',
            'size.max' => 'Ukuran maksimal 50 karakter.',
            'color.max' => 'Warna maksimal 50 karakter.',
            'image.required' => 'Gambar wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
            'image.dimensions' => 'Dimensi gambar harus minimal 300x300 pixel dan maksimal 4000x4000 pixel.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama gear',
            'description' => 'deskripsi',
            'price' => 'harga',
            'category' => 'kategori',
            'stock' => 'stok',
            'size' => 'ukuran',
            'color' => 'warna',
            'image' => 'gambar',
        ];
    }
}
