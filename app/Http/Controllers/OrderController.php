<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Bike;
use App\Models\Gear;
use App\Http\Requests\OrderStoreRequest;

class OrderController extends Controller
{
    /**
     * Display checkout page.
     */
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        $items = [];
        
        foreach ($cartItems as $item) {
            if ($item->product_type === 'bikes') {
                $product = Bike::find($item->product_id);
            } else {
                $product = Gear::find($item->product_id);
            }
            
            if ($product) {
                $items[] = [
                    'cart_item' => $item,
                    'product' => $product,
                    'subtotal' => $product->price * $item->quantity
                ];
                $total += $product->price * $item->quantity;
            }
        }
        
        return view('orders.checkout', compact('items', 'total'));
    }

    /**
     * Store the order.
     */
    public function store(OrderStoreRequest $request)
    {
        $validated = $request->validated();
        
        $userId = auth()->id();
        $items = $validated['items'];
        
        // Calculate total
        $total = 0;
        foreach ($items as $item) {
            if ($item['product_type'] === 'bike') {
                $product = Bike::find($item['product_id']);
            } else {
                $product = Gear::find($item['product_id']);
            }
            
            if ($product) {
                $total += $product->price * $item['quantity'];
            }
        }

        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $validated['shipping_address'],
            'shipping_phone' => $validated['shipping_phone'],
            'shipping_name' => $validated['shipping_name'],
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create order items and update stock
        foreach ($items as $item) {
            if ($item['product_type'] === 'bike') {
                $product = Bike::find($item['product_id']);
            } else {
                $product = Gear::find($item['product_id']);
            }
            
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_type' => $item['product_type'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
                
                // Update stock
                $product->update([
                    'stock' => $product->stock - $item['quantity']
                ]);
            }
        }

        // Clear cart
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Display order history.
     */
    public function history()
    {
        $orders = Order::where('user_id', auth()->id())
                      ->with('orderItems')
                      ->latest()
                      ->paginate(10);
        
        return view('orders.history', compact('orders'));
    }

    /**
     * Display order detail.
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load('orderItems');
        
        return view('orders.show', compact('order'));
    }
}
