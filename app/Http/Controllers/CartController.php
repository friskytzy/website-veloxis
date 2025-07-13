<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Bike;
use App\Models\Gear;
use App\Http\Requests\CartAddRequest;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $total = 0;
        
        foreach ($cartItems as $item) {
            if ($item->product_type === 'bikes') {
                $product = Bike::find($item->product_id);
            } else {
                $product = Gear::find($item->product_id);
            }
            
            if ($product) {
                $total += $product->price * $item->quantity;
            }
        }
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart.
     */
    public function add(CartAddRequest $request)
    {
        $validated = $request->validated();
        
        $userId = auth()->id();
        $productId = $validated['product_id'];
        $productType = $validated['product_type'];
        $quantity = $validated['quantity'];

        // Check if item already exists in cart
        $existingCart = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('product_type', $productType)
            ->first();

        if ($existingCart) {
            // Update quantity
            $existingCart->update([
                'quantity' => $existingCart->quantity + $quantity
            ]);
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'product_type' => $productType,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        // Update cart count in session
        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
        session(['cart_count' => $cartCount]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart.
     */
    public function remove(Cart $cart)
    {
        $cart->delete();

        // Update cart count in session
        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
        session(['cart_count' => $cartCount]);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }
}
