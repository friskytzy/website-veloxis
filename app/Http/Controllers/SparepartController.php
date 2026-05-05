<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SparePart;
use App\Support\OrderNumber;
use App\Support\VeloxisCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SparepartController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'motor_brand', 'model', 'category', 'part_brand', 'min_price', 'max_price']);
        $products = VeloxisCatalog::sortProducts(
            VeloxisCatalog::filteredProducts($filters),
            $request->query('sort')
        );

        $options = VeloxisCatalog::catalogOptions();

        return view('spareparts.index', [
            'products' => $products,
            'brands' => $options['brands'],
            'categories' => $options['categories'],
            'partBrands' => $options['partBrands'],
            'searchSuggestions' => $options['searchSuggestions'],
        ]);
    }

    public function show(string $slug): View
    {
        $product = VeloxisCatalog::findProduct($slug);

        abort_if(!$product, 404);

        $relatedProducts = collect(VeloxisCatalog::filteredProducts([]))
            ->filter(fn (array $item): bool => $item['slug'] !== $slug && ($item['category'] === $product['category'] || $item['motor_brand'] === $product['motor_brand']))
            ->take(4)
            ->values()
            ->all();

        return view('spareparts.show', compact('product', 'relatedProducts'));
    }

    public function addToCart(Request $request, string $slug): RedirectResponse
    {
        $this->storeCartItem($request, $slug);

        return redirect()->route('veloxis.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function buyNow(Request $request, string $slug): RedirectResponse
    {
        $this->storeCartItem($request, $slug);

        return redirect()->route('veloxis.checkout')->with('success', 'Produk siap checkout.');
    }

    private function storeCartItem(Request $request, string $slug): void
    {
        $product = VeloxisCatalog::findProduct($slug);

        abort_if(!$product, 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $requestedQuantity = (int) ($validated['quantity'] ?? 1);
        $cart = session('veloxis_cart', []);
        $cart[$slug] = min(($cart[$slug] ?? 0) + $requestedQuantity, 10, $product['stock']);

        if ($cart[$slug] < 1) {
            unset($cart[$slug]);
        }

        session(['veloxis_cart' => $cart]);
    }

    public function cart(): View
    {
        $items = VeloxisCatalog::cartItems(session('veloxis_cart', []));
        $subtotal = VeloxisCatalog::cartSubtotal($items);
        $shipping = $this->shippingCost($subtotal, 'JNE');
        $discount = $subtotal >= 750000 ? 50000 : 0;

        return view('spareparts.cart', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => max($subtotal + $shipping - $discount, 0),
        ]);
    }

    public function updateCart(Request $request, string $slug): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $cart = session('veloxis_cart', []);

        if ((int) $validated['quantity'] === 0) {
            unset($cart[$slug]);
        } else {
            $product = VeloxisCatalog::findProduct($slug);
            abort_if(!$product, 404);
            $cart[$slug] = min((int) $validated['quantity'], $product['stock']);
        }

        session(['veloxis_cart' => $cart]);

        return redirect()->route('veloxis.cart')->with('success', 'Keranjang diperbarui.');
    }

    public function checkout(): View
    {
        $items = VeloxisCatalog::cartItems(session('veloxis_cart', []));
        $subtotal = VeloxisCatalog::cartSubtotal($items);
        $shipping = $this->shippingCost($subtotal, old('courier', 'JNE'));
        $discount = $subtotal >= 750000 ? 50000 : 0;

        return view('spareparts.checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => max($subtotal + $shipping - $discount, 0),
            'couriers' => $this->activeOptions((array) config('veloxis.couriers')),
            'paymentMethods' => $this->activeOptions((array) config('veloxis.payments')),
        ]);
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:30'],
            'city' => ['required', 'string', 'max:80'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'min:10', 'max:500'],
            'courier' => ['required', 'in:'.implode(',', array_keys($this->activeOptions((array) config('veloxis.couriers'))))],
            'payment_method' => ['required', 'in:'.implode(',', array_keys($this->activeOptions((array) config('veloxis.payments'))))],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $cart = session('veloxis_cart', []);
        $items = VeloxisCatalog::cartItems($cart);

        if (count($items) === 0) {
            return redirect()->route('veloxis.cart')->with('success', 'Keranjang masih kosong.');
        }

        if (!SparePart::active()->exists()) {
            return redirect()->route('veloxis.cart')->withErrors([
                'quantity' => 'Produk belum tersedia untuk checkout. Silakan hubungi admin VELOXIS.',
            ]);
        }

        $stockError = null;
        $order = DB::transaction(function () use ($request, $items, &$stockError): ?Order {
            $paymentMethod = $request->string('payment_method')->toString();
            $paymentProvider = config('veloxis.payments.'.$paymentMethod.'.provider', 'manual');

            $lockedParts = [];
            $subtotal = 0;
            foreach ($items as $item) {
                $part = SparePart::active()->where('slug', $item['slug'])->lockForUpdate()->first();
                if (!$part || $part->stock < $item['quantity']) {
                    $stockError = "Stok {$item['name']} tidak mencukupi. Tersedia: ".($part ? $part->stock : 0);

                    return null;
                }

                $lockedParts[$item['slug']] = $part;
                $subtotal += $part->price * $item['quantity'];
            }

            $shipping = $this->shippingCost($subtotal, $request->string('courier')->toString());
            $discount = $subtotal >= 750000 ? 50000 : 0;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => OrderNumber::generate(),
                'customer_name' => $request->string('name')->toString(),
                'total' => max($subtotal + $shipping - $discount, 0),
                'status' => 'pending',
                'address' => $request->string('address')->toString(),
                'city' => $request->string('city')->toString(),
                'postal_code' => $request->string('postal_code')->toString() ?: null,
                'phone' => $request->string('phone')->toString(),
                'email' => $request->string('email')->toString(),
                'courier' => $request->string('courier')->toString(),
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'discount' => $discount,
                'payment_method' => $paymentMethod,
                'payment_provider' => $paymentProvider,
                'payment_status' => $paymentMethod === 'COD' ? 'cod_pending' : 'waiting_payment',
                'notes' => $request->string('notes')->toString() ?: null,
            ]);

            foreach ($items as $item) {
                $part = $lockedParts[$item['slug']];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $part->id,
                    'product_type' => SparePart::class,
                    'product_name' => $part->name,
                    'quantity' => $item['quantity'],
                    'price' => $part->price,
                ]);

                $part->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        if (!$order) {
            return redirect()->route('veloxis.cart')->withErrors([
                'quantity' => $stockError ?? 'Stok produk tidak mencukupi.',
            ]);
        }

        session()->forget('veloxis_cart');

        session(['veloxis_last_order_id' => $order->id]);

        return redirect()->route('veloxis.order-confirmation')->with('success', 'Order berhasil dibuat. Tim Veloxis akan menghubungi Anda untuk pembayaran dan pengiriman.');
    }

    public function confirmation(): View
    {
        $order = null;
        $orderId = session('veloxis_last_order_id');

        if ($orderId) {
            $order = Order::find($orderId);
        }

        return view('spareparts.confirmation', compact('order'));
    }

    private function shippingCost(int $subtotal, string $courier): int
    {
        if ($subtotal > 500000 || $subtotal === 0) {
            return 0;
        }

        return (int) config('veloxis.couriers.'.$courier.'.base_cost', 18000);
    }

    private function activeOptions(array $options): array
    {
        return array_filter($options, fn (array $option): bool => $option['active'] ?? false);
    }
}
