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
        $orders = DB::table('orders')
            ->select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(20);
            
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = DB::table('orders')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.id', $id)
            ->first();
            
        if (!$order) {
            abort(404);
        }
        
        $items = DB::table('order_items')
            ->where('order_id', $order->id)
            ->get();
            
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
