<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Bike;
use App\Models\Gear;
use App\Models\News;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        // Count summary statistics
        $stats = [
            'orders' => Order::count(),
            'users' => User::count(),
            'products' => [
                'bikes' => Bike::count(),
                'gear' => Gear::count(),
                'total' => Bike::count() + Gear::count()
            ],
            'news' => News::count(),
            'events' => Event::count(),
            'recent_orders' => Order::latest()->take(5)->get()
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
