<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'content' => ['required', 'string', 'min:50', 'max:10000'],
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // 5MB max
                'dimensions:min_width=400,min_height=300,max_width=4000,max_height=4000'
            ],
            'author' => ['required', 'string', 'max:255'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi.',
            'title.min' => 'Judul berita minimal 5 karakter.',
            'title.max' => 'Judul berita maksimal 255 karakter.',
            'content.required' => 'Konten berita wajib diisi.',
            'content.min' => 'Konten berita minimal 50 karakter.',
            'content.max' => 'Konten berita maksimal 10000 karakter.',
            'image.required' => 'Gambar berita wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
            'image.dimensions' => 'Dimensi gambar harus minimal 400x300 pixel dan maksimal 4000x4000 pixel.',
            'author.required' => 'Penulis wajib diisi.',
            'author.max' => 'Penulis maksimal 255 karakter.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul berita',
            'content' => 'konten berita',
            'image' => 'gambar berita',
            'author' => 'penulis',
            'is_published' => 'status publikasi',
        ];
    }
}
