<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Bike;
use App\Models\Gear;

class OrderStoreRequest extends FormRequest
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
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer'],
            'items.*.product_type' => ['required', 'string', 'in:bike,gear'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'shipping_address' => ['required', 'string', 'min:10', 'max:500'],
            'shipping_phone' => ['required', 'string', 'regex:/^[0-9+\-\s()]+$/'],
            'shipping_name' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'in:transfer,cod'],
            'notes' => ['sometimes', 'string', 'max:1000'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            
            foreach ($items as $index => $item) {
                $productId = $item['product_id'] ?? null;
                $productType = $item['product_type'] ?? null;
                $quantity = $item['quantity'] ?? 0;

                if (!$productId || !$productType) {
                    continue;
                }

                // Check if product exists and has sufficient stock
                if ($productType === 'bike') {
                    $product = Bike::find($productId);
                } elseif ($productType === 'gear') {
                    $product = Gear::find($productId);
                } else {
                    $validator->errors()->add("items.{$index}.product_type", 'Tipe produk tidak valid.');
                    continue;
                }

                if (!$product) {
                    $validator->errors()->add("items.{$index}.product_id", 'Produk tidak ditemukan.');
                    continue;
                }

                if ($product->stock < $quantity) {
                    $validator->errors()->add("items.{$index}.quantity", "Stok {$product->name} tidak mencukupi. Tersedia: {$product->stock}");
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
            'items.required' => 'Item pesanan wajib diisi.',
            'items.array' => 'Item pesanan harus berupa array.',
            'items.min' => 'Minimal harus ada 1 item pesanan.',
            'items.*.product_id.required' => 'ID produk wajib diisi.',
            'items.*.product_id.integer' => 'ID produk harus berupa angka.',
            'items.*.product_type.required' => 'Tipe produk wajib diisi.',
            'items.*.product_type.in' => 'Tipe produk harus bike atau gear.',
            'items.*.quantity.required' => 'Jumlah wajib diisi.',
            'items.*.quantity.integer' => 'Jumlah harus berupa angka bulat.',
            'items.*.quantity.min' => 'Jumlah minimal 1.',
            'items.*.quantity.max' => 'Jumlah maksimal 10.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min' => 'Alamat pengiriman minimal 10 karakter.',
            'shipping_address.max' => 'Alamat pengiriman maksimal 500 karakter.',
            'shipping_phone.required' => 'Nomor telepon wajib diisi.',
            'shipping_phone.regex' => 'Format nomor telepon tidak valid.',
            'shipping_name.required' => 'Nama penerima wajib diisi.',
            'shipping_name.max' => 'Nama penerima maksimal 255 karakter.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'items' => 'item pesanan',
            'shipping_address' => 'alamat pengiriman',
            'shipping_phone' => 'nomor telepon',
            'shipping_name' => 'nama penerima',
            'payment_method' => 'metode pembayaran',
            'notes' => 'catatan',
        ];
    }
}
