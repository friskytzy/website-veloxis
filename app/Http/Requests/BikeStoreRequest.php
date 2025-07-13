<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidImageDimensions;

class BikeStoreRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'price' => ['required', 'numeric', 'min:1000000', 'max:1000000000'],
            'category' => ['required', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000'],
            'specifications' => ['sometimes', 'array'],
            'specifications.engine' => ['sometimes', 'string', 'max:100'],
            'specifications.displacement' => ['sometimes', 'string', 'max:50'],
            'specifications.power' => ['sometimes', 'string', 'max:50'],
            'specifications.torque' => ['sometimes', 'string', 'max:50'],
            'specifications.transmission' => ['sometimes', 'string', 'max:50'],
            'specifications.fuel_capacity' => ['sometimes', 'string', 'max:50'],
            'specifications.weight' => ['sometimes', 'string', 'max:50'],
            'is_featured' => ['sometimes', 'boolean'],
        ];
        
        // Different validation rules for create vs update
        if ($this->isMethod('post')) {
            // For creating a new bike
            $rules['image'] = [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // 5MB max
                new ValidImageDimensions(300, 300, 4000, 4000)
            ];
        } else {
            // For updating an existing bike
            $rules['image'] = [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // 5MB max
                new ValidImageDimensions(300, 300, 4000, 4000)
            ];
        }
        
        return $rules;
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama motor wajib diisi.',
            'name.min' => 'Nama motor minimal 3 karakter.',
            'name.max' => 'Nama motor maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
            'description.max' => 'Deskripsi maksimal 2000 karakter.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal Rp 1.000.000.',
            'price.max' => 'Harga maksimal Rp 1.000.000.000.',
            'category.required' => 'Kategori wajib diisi.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok minimal 0.',
            'stock.max' => 'Stok maksimal 1000.',
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
            'name' => 'nama motor',
            'description' => 'deskripsi',
            'price' => 'harga',
            'category' => 'kategori',
            'stock' => 'stok',
            'image' => 'gambar',
            'specifications' => 'spesifikasi',
        ];
    }
}
