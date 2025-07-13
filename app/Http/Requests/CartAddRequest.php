<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Bike;
use App\Models\Gear;
use App\Rules\StockAvailability;

class CartAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer'],
            'product_type' => ['required', 'string', 'in:bike,gear'],
            'quantity' => [
                'required', 
                'integer', 
                'min:1', 
                'max:10',
                new StockAvailability($this->input('product_id'), $this->input('product_type'))
            ],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $productId = $this->input('product_id');
            $productType = $this->input('product_type');
            $quantity = $this->input('quantity');

            // Check if product exists
            if ($productType === 'bike') {
                $product = Bike::find($productId);
            } elseif ($productType === 'gear') {
                $product = Gear::find($productId);
            } else {
                $validator->errors()->add('product_type', 'Tipe produk tidak valid.');
                return;
            }

            if (!$product) {
                $validator->errors()->add('product_id', 'Produk tidak ditemukan.');
                return;
            }

            // Check stock availability
            if ($product->stock < $quantity) {
                $validator->errors()->add('quantity', "Stok {$product->name} tidak mencukupi. Tersedia: {$product->stock}");
            }

            // Check if product is already in cart
            $existingCart = auth()->user()->cart()->where('product_id', $productId)
                ->where('product_type', $productType)
                ->first();

            if ($existingCart) {
                $totalQuantity = $existingCart->quantity + $quantity;
                if ($product->stock < $totalQuantity) {
                    $validator->errors()->add('quantity', "Total stok {$product->name} tidak mencukupi untuk ditambahkan ke keranjang.");
                }
            }
        });
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'ID produk wajib diisi.',
            'product_id.integer' => 'ID produk harus berupa angka.',
            'product_type.required' => 'Tipe produk wajib diisi.',
            'product_type.in' => 'Tipe produk harus bike atau gear.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka bulat.',
            'quantity.min' => 'Jumlah minimal 1.',
            'quantity.max' => 'Jumlah maksimal 10.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'product_id' => 'ID produk',
            'product_type' => 'tipe produk',
            'quantity' => 'jumlah',
        ];
    }
}
