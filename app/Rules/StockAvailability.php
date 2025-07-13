<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Bike;
use App\Models\Gear;

class StockAvailability implements ValidationRule
{
    protected $productId;
    protected $productType;
    protected $currentQuantity;

    public function __construct($productId, $productType, $currentQuantity = 0)
    {
        $this->productId = $productId;
        $this->productType = $productType;
        $this->currentQuantity = $currentQuantity;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value) || $value <= 0) {
            $fail('Jumlah harus berupa angka positif.');
            return;
        }

        // Get product based on type
        if ($this->productType === 'bike') {
            $product = Bike::find($this->productId);
        } elseif ($this->productType === 'gear') {
            $product = Gear::find($this->productId);
        } else {
            $fail('Tipe produk tidak valid.');
            return;
        }

        if (!$product) {
            $fail('Produk tidak ditemukan.');
            return;
        }

        $requestedQuantity = (int) $value;
        $availableStock = $product->stock - $this->currentQuantity;

        if ($availableStock < $requestedQuantity) {
            $fail("Stok {$product->name} tidak mencukupi. Tersedia: {$availableStock}");
        }
    }
}
