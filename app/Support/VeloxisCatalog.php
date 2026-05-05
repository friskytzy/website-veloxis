<?php

namespace App\Support;

use App\Models\SparePart;
use Illuminate\Support\Collection;

class VeloxisCatalog
{
    public static function motorBrands(): array
    {
        return [
            ['name' => 'Honda', 'models' => ['Beat', 'Vario', 'PCX', 'Scoopy']],
            ['name' => 'Yamaha', 'models' => ['NMax', 'Aerox', 'Mio', 'Lexi']],
            ['name' => 'Suzuki', 'models' => ['Satria F150', 'Address', 'Nex II', 'Burgman Street']],
            ['name' => 'Kawasaki', 'models' => ['Ninja 250', 'KLX 150', 'W175', 'D-Tracker']],
        ];
    }

    public static function categories(): array
    {
        return ['Oli', 'Ban', 'Kampas Rem', 'Rantai & Gear', 'Aki', 'Busi'];
    }

    public static function partBrands(): array
    {
        return ['Castrol', 'Shell', 'Motul', 'IRC', 'Maxxis', 'Pirelli', 'Honda Genuine Parts', 'Yamaha Genuine Parts', 'RK', 'DID', 'Yuasa', 'GS Astra', 'NGK', 'Denso'];
    }

    public static function products(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Castrol Power1 Ultimate 10W-40',
                'slug' => 'castrol-power1-ultimate-10w-40',
                'sku' => 'VLX-OLI-001',
                'category' => 'Oli',
                'part_brand' => 'Castrol',
                'motor_brand' => 'Honda',
                'models' => ['Beat', 'Vario', 'Scoopy'],
                'years' => '2018-2025',
                'price' => 78000,
                'stock' => 42,
                'rating' => 4.5,
                'review_count' => 128,
                'image' => 'https://images.unsplash.com/photo-1635435934249-5df7ed86e1c0?auto=format&fit=crop&w=900&q=80',
                'description' => 'Oli synthetic blend untuk mesin harian yang lebih halus, responsif, dan tahan panas di lalu lintas perkotaan.',
                'specifications' => ['Volume 0.8L', 'SAE 10W-40', 'API SN', 'JASO MA2'],
                'badge' => 'Genuine',
            ],
            [
                'id' => 2,
                'name' => 'Shell Advance AX7 Scooter 10W-40',
                'slug' => 'shell-advance-ax7-scooter-10w-40',
                'sku' => 'VLX-OLI-002',
                'category' => 'Oli',
                'part_brand' => 'Shell',
                'motor_brand' => 'Yamaha',
                'models' => ['NMax', 'Aerox', 'Mio'],
                'years' => '2017-2025',
                'price' => 82000,
                'stock' => 36,
                'rating' => 4.4,
                'review_count' => 94,
                'image' => 'https://images.unsplash.com/photo-1599256872237-5dcc0fbe9668?auto=format&fit=crop&w=900&q=80',
                'description' => 'Oli motor matic dengan formula active cleansing untuk menjaga akselerasi tetap ringan.',
                'specifications' => ['Volume 1L', 'SAE 10W-40', 'API SL', 'JASO MB'],
                'badge' => 'Best Seller',
            ],
            [
                'id' => 3,
                'name' => 'Motul Scooter Power LE 5W-40',
                'slug' => 'motul-scooter-power-le-5w-40',
                'sku' => 'VLX-OLI-003',
                'category' => 'Oli',
                'part_brand' => 'Motul',
                'motor_brand' => 'Honda',
                'models' => ['PCX', 'Vario'],
                'years' => '2019-2025',
                'price' => 125000,
                'stock' => 18,
                'rating' => 4.5,
                'review_count' => 57,
                'image' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=900&q=80',
                'description' => 'Oli full synthetic untuk skutik premium dengan proteksi ekstra pada temperatur tinggi.',
                'specifications' => ['Volume 1L', 'SAE 5W-40', 'API SN', 'JASO MB'],
                'badge' => 'Premium',
            ],
            [
                'id' => 4,
                'name' => 'IRC Enviro NR87 80/90-14',
                'slug' => 'irc-enviro-nr87-80-90-14',
                'sku' => 'VLX-BAN-004',
                'category' => 'Ban',
                'part_brand' => 'IRC',
                'motor_brand' => 'Honda',
                'models' => ['Beat', 'Scoopy'],
                'years' => '2016-2025',
                'price' => 215000,
                'stock' => 26,
                'rating' => 4.3,
                'review_count' => 81,
                'image' => 'https://images.unsplash.com/photo-1617814076668-0472dd6e4188?auto=format&fit=crop&w=900&q=80',
                'description' => 'Ban harian irit dan stabil untuk jalan basah maupun kering.',
                'specifications' => ['Tubeless', '80/90-14', 'Compound eco', 'Front/rear compatible'],
                'badge' => 'Ready Stock',
            ],
            [
                'id' => 5,
                'name' => 'Pirelli Diablo Rosso Scooter 120/70-13',
                'slug' => 'pirelli-diablo-rosso-scooter-120-70-13',
                'sku' => 'VLX-BAN-005',
                'category' => 'Ban',
                'part_brand' => 'Pirelli',
                'motor_brand' => 'Yamaha',
                'models' => ['NMax', 'Aerox'],
                'years' => '2018-2025',
                'price' => 465000,
                'stock' => 12,
                'rating' => 4.5,
                'review_count' => 49,
                'image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=900&q=80',
                'description' => 'Ban performa untuk skutik besar dengan grip menikung yang presisi.',
                'specifications' => ['Tubeless', '120/70-13', 'Sport compound', 'Rear tire'],
                'badge' => 'Performance',
            ],
            [
                'id' => 6,
                'name' => 'Maxxis Victra S98 ST 90/80-14',
                'slug' => 'maxxis-victra-s98-st-90-80-14',
                'sku' => 'VLX-BAN-006',
                'category' => 'Ban',
                'part_brand' => 'Maxxis',
                'motor_brand' => 'Suzuki',
                'models' => ['Address', 'Nex II'],
                'years' => '2017-2025',
                'price' => 248000,
                'stock' => 20,
                'rating' => 4.2,
                'review_count' => 33,
                'image' => 'https://images.unsplash.com/photo-1600661653561-629509216228?auto=format&fit=crop&w=900&q=80',
                'description' => 'Ban touring komuter dengan alur anti-slip dan umur pakai panjang.',
                'specifications' => ['Tubeless', '90/80-14', 'Touring tread', 'Rear tire'],
                'badge' => 'Value',
            ],
            [
                'id' => 7,
                'name' => 'Honda Genuine Kampas Rem Depan Beat',
                'slug' => 'honda-genuine-kampas-rem-depan-beat',
                'sku' => 'VLX-REM-007',
                'category' => 'Kampas Rem',
                'part_brand' => 'Honda Genuine Parts',
                'motor_brand' => 'Honda',
                'models' => ['Beat', 'Scoopy', 'Vario'],
                'years' => '2018-2025',
                'price' => 69000,
                'stock' => 54,
                'rating' => 4.5,
                'review_count' => 151,
                'image' => 'https://images.unsplash.com/photo-1613214149922-f1809c99b414?auto=format&fit=crop&w=900&q=80',
                'description' => 'Kampas rem original dengan gigitan halus, minim bunyi, dan aman untuk cakram standar.',
                'specifications' => ['Front disc pad', 'OEM compound', 'Anti-noise shim', '1 set'],
                'badge' => 'OEM',
            ],
            [
                'id' => 8,
                'name' => 'Yamaha Genuine Brake Pad NMax',
                'slug' => 'yamaha-genuine-brake-pad-nmax',
                'sku' => 'VLX-REM-008',
                'category' => 'Kampas Rem',
                'part_brand' => 'Yamaha Genuine Parts',
                'motor_brand' => 'Yamaha',
                'models' => ['NMax', 'Aerox'],
                'years' => '2018-2025',
                'price' => 88000,
                'stock' => 31,
                'rating' => 4.4,
                'review_count' => 72,
                'image' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?auto=format&fit=crop&w=900&q=80',
                'description' => 'Kampas rem genuine untuk pengereman konsisten saat harian dan touring ringan.',
                'specifications' => ['Front/rear disc pad', 'OEM Yamaha', 'Low dust', '1 set'],
                'badge' => 'OEM',
            ],
            [
                'id' => 9,
                'name' => 'RK Chain Kit 428H + Gear Set',
                'slug' => 'rk-chain-kit-428h-gear-set',
                'sku' => 'VLX-RNT-009',
                'category' => 'Rantai & Gear',
                'part_brand' => 'RK',
                'motor_brand' => 'Suzuki',
                'models' => ['Satria F150'],
                'years' => '2016-2024',
                'price' => 320000,
                'stock' => 14,
                'rating' => 4.3,
                'review_count' => 39,
                'image' => 'https://images.unsplash.com/photo-1558980394-0a06c46397d8?auto=format&fit=crop&w=900&q=80',
                'description' => 'Paket rantai dan gear untuk tarikan lebih responsif dan tahan aus.',
                'specifications' => ['428H chain', '14T/43T gear', 'Gold finish', 'Heavy duty'],
                'badge' => 'Kit Lengkap',
            ],
            [
                'id' => 10,
                'name' => 'DID 520 VX3 Chain Kawasaki Ninja 250',
                'slug' => 'did-520-vx3-chain-kawasaki-ninja-250',
                'sku' => 'VLX-RNT-010',
                'category' => 'Rantai & Gear',
                'part_brand' => 'DID',
                'motor_brand' => 'Kawasaki',
                'models' => ['Ninja 250', 'D-Tracker'],
                'years' => '2018-2025',
                'price' => 780000,
                'stock' => 8,
                'rating' => 4.5,
                'review_count' => 21,
                'image' => 'https://images.unsplash.com/photo-1625047509248-ec889cbff17f?auto=format&fit=crop&w=900&q=80',
                'description' => 'Rantai X-ring premium untuk motor sport dengan durabilitas tinggi.',
                'specifications' => ['520 pitch', 'X-ring', '112 links', 'Tensile strength 8,210 lbs'],
                'badge' => 'Premium',
            ],
            [
                'id' => 11,
                'name' => 'Yuasa YTZ6V MF Battery',
                'slug' => 'yuasa-ytz6v-mf-battery',
                'sku' => 'VLX-AKI-011',
                'category' => 'Aki',
                'part_brand' => 'Yuasa',
                'motor_brand' => 'Honda',
                'models' => ['Beat', 'Vario', 'Scoopy'],
                'years' => '2017-2025',
                'price' => 245000,
                'stock' => 22,
                'rating' => 4.4,
                'review_count' => 66,
                'image' => 'https://images.unsplash.com/photo-1609619385002-f40f1df9b7eb?auto=format&fit=crop&w=900&q=80',
                'description' => 'Aki maintenance free untuk starter stabil dan lampu lebih konsisten.',
                'specifications' => ['12V 5Ah', 'MF sealed', 'CCA tinggi', 'Garansi 6 bulan'],
                'badge' => 'Garansi',
            ],
            [
                'id' => 12,
                'name' => 'GS Astra GTZ7S Battery',
                'slug' => 'gs-astra-gtz7s-battery',
                'sku' => 'VLX-AKI-012',
                'category' => 'Aki',
                'part_brand' => 'GS Astra',
                'motor_brand' => 'Yamaha',
                'models' => ['NMax', 'Aerox', 'Lexi'],
                'years' => '2018-2025',
                'price' => 315000,
                'stock' => 16,
                'rating' => 4.3,
                'review_count' => 44,
                'image' => 'https://images.unsplash.com/photo-1562141961-ef7c42f064d6?auto=format&fit=crop&w=900&q=80',
                'description' => 'Aki MF lokal terpercaya untuk motor matic premium dan touring harian.',
                'specifications' => ['12V 6Ah', 'Sealed MF', 'Low self-discharge', 'Garansi toko'],
                'badge' => 'Original',
            ],
            [
                'id' => 13,
                'name' => 'NGK CPR8EA-9 Spark Plug',
                'slug' => 'ngk-cpr8ea-9-spark-plug',
                'sku' => 'VLX-BUS-013',
                'category' => 'Busi',
                'part_brand' => 'NGK',
                'motor_brand' => 'Honda',
                'models' => ['Beat', 'Vario', 'PCX'],
                'years' => '2016-2025',
                'price' => 28000,
                'stock' => 75,
                'rating' => 4.4,
                'review_count' => 184,
                'image' => 'https://images.unsplash.com/photo-1593941707882-a5bac6861d75?auto=format&fit=crop&w=900&q=80',
                'description' => 'Busi standar berkualitas untuk pembakaran stabil dan irit bahan bakar.',
                'specifications' => ['Nickel electrode', 'Gap 0.9mm', 'Heat range 8', 'OEM replacement'],
                'badge' => 'Murah Cepat',
            ],
            [
                'id' => 14,
                'name' => 'Denso Iridium IU24',
                'slug' => 'denso-iridium-iu24',
                'sku' => 'VLX-BUS-014',
                'category' => 'Busi',
                'part_brand' => 'Denso',
                'motor_brand' => 'Kawasaki',
                'models' => ['Ninja 250', 'W175'],
                'years' => '2017-2025',
                'price' => 118000,
                'stock' => 19,
                'rating' => 4.5,
                'review_count' => 36,
                'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=900&q=80',
                'description' => 'Busi iridium untuk respons gas tajam, usia pakai panjang, dan idle stabil.',
                'specifications' => ['Iridium electrode', '0.4mm tip', 'High ignitability', 'Long life'],
                'badge' => 'Upgrade',
            ],
        ];
    }

    public static function findProduct(string $slug): ?array
    {
        $databaseProduct = SparePart::active()->where('slug', $slug)->first();

        if ($databaseProduct) {
            return $databaseProduct->toCatalogArray();
        }

        if (SparePart::active()->exists()) {
            return null;
        }

        foreach (self::products() as $product) {
            if ($product['slug'] === $slug) {
                return $product;
            }
        }

        return null;
    }

    public static function filteredProducts(array $filters): array
    {
        $products = SparePart::active()->exists()
            ? SparePart::active()->get()->map(fn (SparePart $part): array => $part->toCatalogArray())->all()
            : self::products();

        return array_values(array_filter($products, function (array $product) use ($filters): bool {
            $search = strtolower((string) ($filters['search'] ?? ''));
            if ($search !== '') {
                $haystack = strtolower($product['name'] . ' ' . $product['description'] . ' ' . $product['category'] . ' ' . $product['part_brand'] . ' ' . $product['motor_brand'] . ' ' . implode(' ', $product['models']));
                if (strpos($haystack, $search) === false) {
                    return false;
                }
            }

            if (!empty($filters['motor_brand']) && $product['motor_brand'] !== $filters['motor_brand']) {
                return false;
            }

            if (!empty($filters['model']) && !in_array($filters['model'], $product['models'], true)) {
                return false;
            }

            if (!empty($filters['category']) && $product['category'] !== $filters['category']) {
                return false;
            }

            if (!empty($filters['part_brand']) && $product['part_brand'] !== $filters['part_brand']) {
                return false;
            }

            if (!empty($filters['min_price']) && $product['price'] < (int) $filters['min_price']) {
                return false;
            }

            if (!empty($filters['max_price']) && $product['price'] > (int) $filters['max_price']) {
                return false;
            }

            return true;
        }));
    }

    public static function sortProducts(array $products, ?string $sort): array
    {
        usort($products, function (array $first, array $second) use ($sort): int {
            if ($sort === 'price_asc') {
                return $first['price'] <=> $second['price'];
            }

            if ($sort === 'rating') {
                return $second['rating'] <=> $first['rating'];
            }

            if ($sort === 'newest') {
                return $second['id'] <=> $first['id'];
            }

            return $second['review_count'] <=> $first['review_count'];
        });

        return $products;
    }

    public static function cartItems(array $cart): array
    {
        $items = [];

        foreach ($cart as $slug => $quantity) {
            $product = self::findProduct($slug);
            if ($product) {
                $product['quantity'] = $quantity;
                $product['subtotal'] = $product['price'] * $quantity;
                $items[] = $product;
            }
        }

        return $items;
    }

    public static function cartSubtotal(array $items): int
    {
        return (int) array_sum(array_column($items, 'subtotal'));
    }

    public static function catalogOptions(): array
    {
        if (!SparePart::active()->exists()) {
            return [
                'brands' => self::motorBrands(),
                'categories' => self::categories(),
                'partBrands' => self::partBrands(),
                'searchSuggestions' => collect(self::products())->pluck('name')->take(8),
            ];
        }

        $parts = SparePart::active()->get();

        return [
            'brands' => self::brandModelOptions($parts),
            'categories' => $parts->pluck('category')->unique()->sort()->values()->all(),
            'partBrands' => $parts->pluck('part_brand')->unique()->sort()->values()->all(),
            'searchSuggestions' => $parts->pluck('name')->take(8),
        ];
    }

    private static function brandModelOptions(Collection $parts): array
    {
        $brands = [];

        foreach ($parts->groupBy('motor_brand') as $brand => $brandParts) {
            $brands[] = [
                'name' => $brand,
                'models' => $brandParts
                    ->flatMap(fn (SparePart $part): array => $part->compatible_models ?? [])
                    ->unique()
                    ->sort()
                    ->values()
                    ->all(),
            ];
        }

        usort($brands, function (array $first, array $second): int {
            return $first['name'] <=> $second['name'];
        });

        return $brands;
    }
}
