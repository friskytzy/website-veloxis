<?php

namespace App\Http\Controllers;

use App\Support\VeloxisCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return view('spareparts.index', [
            'products' => $products,
            'brands' => VeloxisCatalog::motorBrands(),
            'categories' => VeloxisCatalog::categories(),
            'partBrands' => VeloxisCatalog::partBrands(),
            'searchSuggestions' => collect(VeloxisCatalog::products())->pluck('name')->take(8),
        ]);
    }

    public function show(string $slug): View
    {
        $product = VeloxisCatalog::findProduct($slug);

        abort_if(!$product, 404);

        $relatedProducts = collect(VeloxisCatalog::products())
            ->filter(fn (array $item): bool => $item['slug'] !== $slug && ($item['category'] === $product['category'] || $item['motor_brand'] === $product['motor_brand']))
            ->take(4)
            ->values()
            ->all();

        return view('spareparts.show', compact('product', 'relatedProducts'));
    }

    public function addToCart(Request $request, string $slug): RedirectResponse
    {
        $product = VeloxisCatalog::findProduct($slug);

        abort_if(!$product, 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = session('veloxis_cart', []);
        $cart[$slug] = min(($cart[$slug] ?? 0) + (int) ($validated['quantity'] ?? 1), 10);
        session(['veloxis_cart' => $cart]);

        return redirect()->route('veloxis.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function cart(): View
    {
        $items = VeloxisCatalog::cartItems(session('veloxis_cart', []));
        $subtotal = VeloxisCatalog::cartSubtotal($items);
        $shipping = $subtotal > 500000 || $subtotal === 0 ? 0 : 18000;
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
            $cart[$slug] = (int) $validated['quantity'];
        }

        session(['veloxis_cart' => $cart]);

        return redirect()->route('veloxis.cart')->with('success', 'Keranjang diperbarui.');
    }

    public function checkout(): View
    {
        $items = VeloxisCatalog::cartItems(session('veloxis_cart', []));
        $subtotal = VeloxisCatalog::cartSubtotal($items);
        $shipping = $subtotal > 500000 || $subtotal === 0 ? 0 : 18000;
        $discount = $subtotal >= 750000 ? 50000 : 0;

        return view('spareparts.checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => max($subtotal + $shipping - $discount, 0),
        ]);
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'min:10', 'max:500'],
            'courier' => ['required', 'in:JNE,J&T,SiCepat'],
            'payment_method' => ['required', 'in:Transfer Bank,OVO,GoPay,DANA,COD'],
        ]);

        session()->forget('veloxis_cart');

        return redirect()->route('veloxis.order-confirmation')->with('success', 'Order demo berhasil dibuat. Tim Veloxis akan menghubungi Anda.');
    }

    public function confirmation(): View
    {
        return view('spareparts.confirmation');
    }
}
