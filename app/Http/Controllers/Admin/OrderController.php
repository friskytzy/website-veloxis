<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::query()
            ->with('user')
            ->latest()
            ->paginate(20);
            
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items'])->find($id);

        if (!$order) {
            abort(404);
        }

        $items = $order->items;
            
        return view('admin.orders.show', compact('order', 'items'));
    }

    /**
     * Update the status for the order.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        DB::table('orders')
            ->where('id', $id)
            ->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Order status has been updated');
    }
}
