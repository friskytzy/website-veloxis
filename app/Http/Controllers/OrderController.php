<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Bike;
use App\Models\Gear;
use App\Http\Requests\OrderStoreRequest;
use App\Support\OrderNumber;
use Illuminate\Support\Facades\DB;

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
            if ($item->product_type === 'bike' || $item->product_type === 'bikes') {
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
        
        return view('orders.checkout', [
            'cartItems' => $cartItems,
            'items' => $items,
            'total' => $total,
        ]);
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

        $order = DB::transaction(function () use ($validated, $items, $total, $userId): Order {
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => OrderNumber::generate(),
                'total' => $total,
                'status' => 'pending',
                'address' => $validated['shipping_address'],
                'phone' => $validated['shipping_phone'],
                'customer_name' => $validated['shipping_name'],
                'payment_method' => $validated['payment_method'],
                'payment_provider' => 'manual',
                'payment_status' => $validated['payment_method'] === 'cod' ? 'cod_pending' : 'waiting_payment',
                'notes' => $validated['notes'] ?? null,
            ]);

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
                        'product_name' => $product->name,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                    ]);

                    $product->update([
                        'stock' => $product->stock - $item['quantity']
                    ]);
                }
            }

            return $order;
        });

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
                      ->with('items')
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
        
        $order->load('items');
        
        return view('orders.show', compact('order'));
    }
}
